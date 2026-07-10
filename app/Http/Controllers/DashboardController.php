<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Subject;
use App\Services\LoadComputationService;
use Illuminate\Support\Facades\DB;

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

        $row = DB::selectOne("
            SELECT
                (SELECT COUNT(*) FROM faculties WHERE NOT is_archived) AS faculty_count,
                (SELECT COUNT(*) FROM subjects WHERE NOT is_archived) AS subject_count,
                (SELECT COUNT(*) FROM sections WHERE NOT is_archived) AS section_count,
                (SELECT COUNT(*) FROM rooms WHERE NOT is_archived) AS room_count,
                (SELECT COUNT(*) FROM schedules WHERE status = 'draft') AS draft_schedules,
                (SELECT COUNT(*) FROM schedules WHERE status = 'generated') AS generated_schedules,
                (SELECT COUNT(*) FROM schedules WHERE status = 'reviewed') AS reviewed_schedules,
                (SELECT COUNT(*) FROM schedules WHERE status = 'approved') AS approved_schedules,
                (SELECT COUNT(*) FROM schedules WHERE status = 'finalized') AS finalized_schedules
        ");
        $stats = (array) $row;

        return view('dashboard', compact('stats'));
    }
}
