<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SemesterArchive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $archives = SemesterArchive::orderBy('created_at', 'desc')->paginate(15);
        return view('archives.index', compact('archives'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|in:1st,2nd,summer',
        ]);

        $schedules = Schedule::where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->where('status', 'finalized')
            ->with(['faculty', 'subject', 'section', 'room'])
            ->get();

        if ($schedules->isEmpty()) {
            return back()->withErrors(['error' => 'No finalized schedules found for this semester.']);
        }

        SemesterArchive::create([
            'academic_year' => $validated['academic_year'],
            'semester' => $validated['semester'],
            'archived_at' => now(),
            'data' => $schedules->toArray(),
        ]);

        Schedule::where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->delete();

        return redirect()->route('archives.index')
            ->with('success', 'Semester archived successfully.');
    }

    public function show(SemesterArchive $archive)
    {
        return view('archives.show', compact('archive'));
    }
}
