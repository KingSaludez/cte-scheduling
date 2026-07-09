<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Services\SchedulingService;
use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['faculty', 'subject', 'section', 'room']);

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->orderBy('day')->orderBy('start_time')->paginate(20);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedules.generate');
    }

    public function generate(Request $request, SchedulingService $service)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|in:1st,2nd,summer',
        ]);

        $count = $service->generate($validated['academic_year'], $validated['semester'])->count();

        return redirect()->route('schedules.index', [
            'academic_year' => $validated['academic_year'],
            'semester' => $validated['semester'],
        ])->with('success', "Schedule generated successfully. {$count} entries created.");
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['faculty', 'subject', 'section', 'room', 'creator']);
        return view('schedules.show', compact('schedule'));
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')
            ->with('success', 'Schedule entry deleted.');
    }
}
