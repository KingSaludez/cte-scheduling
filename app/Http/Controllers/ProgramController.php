<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Subject;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::active()->withCount('subjects')->orderBy('name')->get();
        return view('programs.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code',
            'description' => 'nullable|string|max:500',
        ]);

        Program::create($validated);

        return redirect()->route('programs.index')->with('success', 'Program created successfully.');
    }

    public function subjects(Program $program, Request $request)
    {
        $program->load('subjects');
        $yearLevel = $request->year_level ?? 1;
        $semester = $request->semester ?? '1st';

        $subjects = Subject::where('program_id', $program->id)
            ->where('year_level', $yearLevel)
            ->where('semester', $semester)
            ->orderBy('code')
            ->get();

        $allYears = [1, 2, 3, 4, 5, 6];
        $semesters = ['1st', '2nd', 'summer'];

        return view('programs.subjects', compact('program', 'subjects', 'yearLevel', 'semester', 'allYears', 'semesters'));
    }

    public function createSubject(Program $program, Request $request)
    {
        $yearLevel = $request->year_level ?? 1;
        $semester = $request->semester ?? '1st';

        // Get subjects with same base name (e.g., PATHFit 1, PATHFit 2) for prerequisites
        $existingSubjects = Subject::where('program_id', $program->id)
            ->where(function ($q) {
                $q->whereRaw('1=0'); // start with no match, we'll add conditions
            })
            ->get();

        // For prerequisite: get subjects from lower year/semester in same program
        $prereqPool = Subject::where('program_id', $program->id)
            ->where(function ($q) use ($yearLevel, $semester) {
                $q->where('year_level', '<', $yearLevel);
                if ($semester === '2nd') {
                    $q->orWhere(function ($q2) use ($yearLevel) {
                        $q2->where('year_level', $yearLevel)->where('semester', '1st');
                    });
                } elseif ($semester === 'summer') {
                    $q->orWhere(function ($q2) use ($yearLevel) {
                        $q2->where('year_level', $yearLevel)->whereIn('semester', ['1st', '2nd']);
                    });
                }
            })
            ->orderBy('code')
            ->get();

        $allYears = [1, 2, 3, 4, 5, 6];
        $semesters = ['1st', '2nd', 'summer'];

        return view('programs.create-subject', compact('program', 'yearLevel', 'semester', 'prereqPool', 'allYears', 'semesters'));
    }

    public function storeSubject(Program $program, Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'units' => 'required|integer|min:1|max:15',
            'lecture_hours' => 'nullable|integer|min:0',
            'lab_hours' => 'nullable|integer|min:0',
            'year_level' => 'required|integer|min:1|max:6',
            'semester' => 'required|in:1st,2nd,summer',
            'prerequisites' => 'nullable|string|max:500',
        ]);

        $validated['program_id'] = $program->id;

        Subject::create($validated);

        return redirect()->route('programs.subjects', [
            'program' => $program->id,
            'year_level' => $validated['year_level'],
            'semester' => $validated['semester'],
        ])->with('success', 'Subject added successfully.');
    }
}
