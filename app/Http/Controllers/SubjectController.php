<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $subjects = $query->orderBy('code')->paginate(15);

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('code')->get();
        return view('subjects.create', compact('subjects'));
    }

    public function store(StoreSubjectRequest $request)
    {
        Subject::create($request->validated());

        return redirect()->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load('qualifiedFaculties');
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $subjects = Subject::where('id', '!=', $subject->id)->orderBy('code')->get();
        return view('subjects.edit', compact('subject', 'subjects'));
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return redirect()->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
