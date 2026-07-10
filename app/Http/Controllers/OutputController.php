<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutputController extends Controller
{
    public function matrix(Request $request)
    {
        $rooms = Room::active()->with('sections')->orderBy('room_number')->get();
        $dayLabels = ['M' => 'Monday', 'T' => 'Tuesday', 'Th' => 'Thursday', 'F' => 'Friday', 'S' => 'Saturday'];
        $selectedDayCode = $request->day ?? 'M';
        $selectedDay = $dayLabels[$selectedDayCode] ?? 'Monday';

        $timeSlots = [];
        $timeLabels = [];
        for ($h = 7; $h <= 20; $h++) {
            $hStr = sprintf('%02d', $h);
            $timeSlots[] = $hStr . ':00';
            $timeLabels[$hStr . ':00'] = ($h > 12 ? $h - 12 : $h) . ':00 ' . ($h >= 12 ? 'PM' : 'AM');
            $timeSlots[] = $hStr . ':30';
            $timeLabels[$hStr . ':30'] = ($h > 12 ? $h - 12 : $h) . ':30 ' . ($h >= 12 ? 'PM' : 'AM');
        }

        $academicYear = $request->academic_year ?? date('Y') . '-' . (date('Y') + 1);
        $semester = $request->semester ?? '1st';

        $schedules = Schedule::with(['faculty', 'subject', 'section', 'room'])
            ->where('day', $selectedDay)
            ->where('academic_year', $academicYear)
            ->where('semester', $semester)
            ->orderBy('start_time')
            ->get();

        $subjects = Subject::active()->orderBy('code')->get();
        $faculties = Faculty::active()->orderBy('full_name')->get();

        $matrix = [];
        foreach ($schedules as $s) {
            $key = $s->section_id . '-' . $s->room_id;
            $matrix[$key][$s->start_time] = $s;
        }

        $columns = [];
        foreach ($rooms as $room) {
            if ($room->sections->count() > 0) {
                foreach ($room->sections as $section) {
                    $columns[] = ['room' => $room, 'section' => $section, 'key' => $section->id . '-' . $room->id];
                }
            }
        }

        $lunchSlots = ['12:00', '12:30'];
        $cellStates = [];
        $cellMeta = [];
        foreach ($columns as $col) {
            $key = $col['key'];
            $scheds = $matrix[$key] ?? [];
            $states = [];
            $meta = [];
            foreach ($timeSlots as $t) {
                $states[$t] = in_array($t, $lunchSlots) ? 'lunch' : 'empty';
                $meta[$t] = null;
            }
            foreach ($scheds as $startTime => $sched) {
                $startIdx = array_search($startTime, $timeSlots);
                if ($startIdx === false) continue;
                $endIdx = array_search($sched->end_time, $timeSlots);
                if ($endIdx === false || $endIdx <= $startIdx) $endIdx = count($timeSlots);
                $lunchIdx = array_search('12:00', $timeSlots);
                if ($lunchIdx !== false && $startIdx < $lunchIdx && $endIdx > $lunchIdx) {
                    $endIdx = $lunchIdx;
                }
                $rowspan = $endIdx - $startIdx;
                if ($rowspan <= 0) continue;
                $states[$startTime] = 'schedule';
                $meta[$startTime] = ['schedule' => $sched, 'rowspan' => $rowspan];
                for ($j = $startIdx + 1; $j < $endIdx; $j++) {
                    if (!in_array($timeSlots[$j], $lunchSlots)) {
                        $states[$timeSlots[$j]] = 'skip';
                    }
                }
            }
            $cellStates[$key] = $states;
            $cellMeta[$key] = $meta;
        }

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('outputs.matrix-pdf', compact('columns', 'timeSlots', 'matrix', 'selectedDay', 'selectedDayCode', 'dayLabels', 'academicYear', 'semester'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('master-schedule-matrix.pdf');
        }

        $pageTitle = 'Master Schedule Matrix';
        return view('outputs.matrix', compact('columns', 'timeSlots', 'timeLabels', 'matrix', 'selectedDay', 'selectedDayCode', 'dayLabels', 'subjects', 'faculties', 'academicYear', 'semester', 'pageTitle', 'cellStates', 'cellMeta'));
    }

    public function matrixStore(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'faculty_id' => 'required|exists:faculties,faculty_id',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'days' => 'required|array',
            'days.*' => 'in:M,T,Th,F,S',
            'academic_year' => 'required|string',
            'semester' => 'required|in:1st,2nd,summer',
        ]);

        $section = Section::findOrFail($validated['section_id']);
        $subject = Subject::findOrFail($validated['subject_id']);
        $roomId = $section->room_id;

        if (!$roomId) {
            return response()->json(['error' => 'Section has no assigned room'], 422);
        }

        $conflicts = [];
        $created = [];

        foreach ($validated['days'] as $dayCode) {
            $dayLabels = ['M' => 'Monday', 'T' => 'Tuesday', 'Th' => 'Thursday', 'F' => 'Friday', 'S' => 'Saturday'];
            $day = $dayLabels[$dayCode];

            $conflict = $this->checkConflict($roomId, $validated['faculty_id'], $day, $validated['start_time'], $validated['end_time'], $section->id);
            if ($conflict) {
                $conflicts[] = $conflict . ' on ' . $day;
                continue;
            }

            $sched = Schedule::create([
                'faculty_id' => $validated['faculty_id'],
                'subject_id' => $validated['subject_id'],
                'section_id' => $validated['section_id'],
                'room_id' => $roomId,
                'day' => $day,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => 'draft',
                'semester' => $validated['semester'],
                'academic_year' => $validated['academic_year'],
                'created_by' => Auth::id(),
            ]);
            $created[] = $sched;
        }

        $warnings = count($conflicts) > 0
            ? count($created) . ' created, but conflicts blocked: ' . implode('; ', $conflicts)
            : null;

        return response()->json([
            'success' => true,
            'count' => count($created),
            'warnings' => $warnings,
        ]);
    }

    public function matrixDestroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json(['success' => true]);
    }

    private function checkConflict($roomId, $facultyId, $day, $start, $end, $excludeSectionId = null)
    {
        $query = Schedule::where('day', $day)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start);

        $roomConflict = (clone $query)->where('room_id', $roomId)
            ->when($excludeSectionId, fn($q) => $q->where('section_id', '!=', $excludeSectionId))
            ->first();
        if ($roomConflict) {
            return 'Room already booked for ' . ($roomConflict->section->name ?? 'another section') . ' (' . $roomConflict->subject->code . ')';
        }

        $facultyConflict = (clone $query)->where('faculty_id', $facultyId)->first();
        if ($facultyConflict) {
            return 'Faculty already assigned to ' . ($facultyConflict->section->name ?? 'another section') . ' (' . $facultyConflict->subject->code . ')';
        }

        return null;
    }

    public function workload(Request $request)
    {
        $faculties = Faculty::active()
            ->with(['schedules' => fn($q) => $q->with(['subject', 'section', 'room'])->orderBy('day')->orderBy('start_time')])
            ->orderBy('full_name')
            ->paginate(10);

        return view('outputs.workload', compact('faculties'));
    }

    public function workloadPdf(Faculty $faculty)
    {
        $faculty->load(['schedules.subject', 'schedules.section', 'schedules.room']);
        $totalUnits = $faculty->schedules->sum(fn($s) => $s->subject->units ?? 0);
        $preparations = $faculty->schedules->pluck('subject_id')->unique()->count();
        $pdf = Pdf::loadView('outputs.workload-pdf', compact('faculty', 'totalUnits', 'preparations'));
        return $pdf->download("faculty-workload-{$faculty->faculty_id}.pdf");
    }

    public function classProgram(Request $request)
    {
        $sections = Section::active()->orderBy('name')->get();
        $program = null;
        $schedules = collect();

        if ($request->filled('section_id')) {
            $program = Section::find($request->section_id);
        }
        if (!$program) {
            $program = $sections->first();
        }
        if ($program) {
            $schedules = Schedule::with(['faculty', 'subject', 'room'])
                ->where('section_id', $program->id)
                ->orderBy('day')->orderBy('start_time')
                ->get();
        }

        if ($request->has('pdf') && $program) {
            $pdf = Pdf::loadView('outputs.class-program-pdf', compact('program', 'schedules'));
            $name = str_replace(' ', '-', $program->name);
            return $pdf->download("class-program-{$name}.pdf");
        }

        return view('outputs.class-program', compact('sections', 'program', 'schedules'));
    }

    public function classProgramPdf(Section $section)
    {
        $schedules = Schedule::with(['faculty', 'subject', 'room'])
            ->where('section_id', $section->id)
            ->orderBy('day')->orderBy('start_time')
            ->get();
        $pdf = Pdf::loadView('outputs.class-program-pdf', compact('section', 'schedules'));
        $name = str_replace(' ', '-', $section->name);
        return $pdf->download("class-program-{$name}.pdf");
    }
}
