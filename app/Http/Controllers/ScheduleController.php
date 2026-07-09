<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\ScheduleAuditLog;
use App\Models\Section;
use App\Models\Subject;
use App\Services\ConflictDetectionService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function edit(Schedule $schedule)
    {
        $schedule->load(['faculty', 'subject', 'section', 'room']);
        $faculties = Faculty::active()->with('qualifications')->orderBy('full_name')->get();
        $subjects = Subject::active()->orderBy('code')->get();
        $sections = Section::active()->orderBy('name')->get();
        $rooms = Room::active()->orderBy('room_number')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('schedules.edit', compact('schedule', 'faculties', 'subjects', 'sections', 'rooms', 'days'));
    }

    public function update(Request $request, Schedule $schedule, ConflictDetectionService $conflict)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,faculty_id',
            'subject_id' => 'required|exists:subjects,id',
            'section_id' => 'required|exists:sections,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string|max:500',
        ]);

        $data = array_merge($validated, ['schedule_id' => $schedule->id]);
        $errors = $conflict->checkAll($data);

        if ($errors->isNotEmpty()) {
            return back()->withErrors(['conflict' => $errors->implode('<br>')])->withInput();
        }

        $oldValues = $schedule->only(['faculty_id', 'subject_id', 'section_id', 'room_id', 'day', 'start_time', 'end_time']);
        $schedule->update($validated);

        ScheduleAuditLog::create([
            'schedule_id' => $schedule->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'old_values' => $oldValues,
            'new_values' => $validated,
        ]);

        return redirect()->route('schedules.show', $schedule)
            ->with('success', 'Schedule updated successfully.');
    }

    public function updateStatus(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,generated,reviewed,approved,finalized',
        ]);

        $allowed = [
            'draft' => ['generated'],
            'generated' => ['reviewed'],
            'reviewed' => ['approved'],
            'approved' => ['finalized'],
            'finalized' => [],
        ];

        $current = $schedule->status;
        if (!in_array($validated['status'], $allowed[$current] ?? [])) {
            return back()->withErrors(['status' => "Cannot transition from '{$current}' to '{$validated['status']}'."]);
        }

        $oldStatus = $schedule->status;
        $schedule->update(['status' => $validated['status']]);

        ScheduleAuditLog::create([
            'schedule_id' => $schedule->id,
            'user_id' => auth()->id(),
            'action' => 'status_changed',
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $validated['status']],
        ]);

        return redirect()->route('schedules.show', $schedule)
            ->with('success', "Status changed to '{$validated['status']}'.");
    }
}
