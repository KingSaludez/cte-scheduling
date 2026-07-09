<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Subject;
use App\Services\LoadComputationService;

class DashboardController extends Controller
{
    public function index(LoadComputationService $loadService)
    {
        $user = auth()->user();

        if ($user->isFaculty() && $user->faculty) {
            $load = $loadService->compute($user->faculty);
            $schedules = Schedule::with(['subject', 'section', 'room'])
                ->where('faculty_id', $user->faculty_id)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            $weeklySchedule = $schedules->groupBy('day');

            return view('dashboard', compact('load', 'weeklySchedule', 'schedules'));
        }

        $stats = [
            'faculty_count' => Faculty::active()->count(),
            'subject_count' => Subject::active()->count(),
            'section_count' => Section::active()->count(),
            'room_count' => Room::active()->count(),
            'draft_schedules' => Schedule::where('status', 'draft')->count(),
            'generated_schedules' => Schedule::where('status', 'generated')->count(),
            'reviewed_schedules' => Schedule::where('status', 'reviewed')->count(),
            'approved_schedules' => Schedule::where('status', 'approved')->count(),
            'finalized_schedules' => Schedule::where('status', 'finalized')->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
