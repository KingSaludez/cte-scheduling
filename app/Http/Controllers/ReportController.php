<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function facultyWorkload()
    {
        $faculties = Faculty::active()->with(['schedules.subject', 'schedules.section'])->get();
        $faculties->each(function ($f) {
            $f->total_units = $f->schedules->sum(fn($s) => $s->subject->units ?? 0);
        });

        $pdf = Pdf::loadView('reports.faculty-workload', compact('faculties'));
        return $pdf->download('faculty-workload-report.pdf');
    }

    public function facultySchedule(Faculty $faculty)
    {
        $faculty->load(['schedules.subject', 'schedules.section', 'schedules.room']);
        $schedules = $faculty->schedules->groupBy('day');

        $pdf = Pdf::loadView('reports.faculty-schedule', compact('faculty', 'schedules'));
        return $pdf->download("faculty-schedule-{$faculty->faculty_id}.pdf");
    }

    public function classProgram()
    {
        $schedules = Schedule::with(['faculty', 'subject', 'section', 'room'])
            ->orderBy('section_id')->orderBy('day')->orderBy('start_time')
            ->get()
            ->groupBy(fn($s) => "{$s->section->name} - Year {$s->section->year_level}");

        $pdf = Pdf::loadView('reports.class-program', compact('schedules'));
        return $pdf->download('class-program.pdf');
    }

    public function subjectAssignments()
    {
        $subjects = Subject::active()->with(['schedules.faculty', 'schedules.section'])->get();

        $pdf = Pdf::loadView('reports.subject-assignments', compact('subjects'));
        return $pdf->download('subject-assignments.pdf');
    }

    public function roomUtilization()
    {
        $rooms = Room::active()->with('schedules.subject', 'schedules.faculty', 'schedules.section')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $pdf = Pdf::loadView('reports.room-utilization', compact('rooms', 'days'));
        return $pdf->download('room-utilization.pdf');
    }
}
