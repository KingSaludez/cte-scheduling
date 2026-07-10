<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OutputController extends Controller
{
    public function matrix(Request $request)
    {
        $rooms = Room::active()->orderBy('room_number')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $timeSlots = [];
        for ($h = 7; $h <= 17; $h++) {
            $timeSlots[] = sprintf('%02d:00', $h);
        }

        $schedules = Schedule::with(['faculty', 'subject', 'section', 'room'])
            ->when($request->filled('academic_year'), fn($q) => $q->where('academic_year', $request->academic_year))
            ->when($request->filled('semester'), fn($q) => $q->where('semester', $request->semester))
            ->when($request->filled('day'), fn($q) => $q->where('day', $request->day))
            ->orderBy('day')->orderBy('start_time')
            ->get();

        $matrix = [];
        foreach ($schedules as $s) {
            $matrix[$s->day][$s->room_id][$s->start_time] = $s;
        }

        $selectedDay = $request->day ?? 'Monday';

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('outputs.matrix-pdf', compact('rooms', 'timeSlots', 'matrix', 'days', 'selectedDay'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('master-schedule-matrix.pdf');
        }

        return view('outputs.matrix', compact('rooms', 'timeSlots', 'matrix', 'days', 'selectedDay'));
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
