<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::query();

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('employment_status')) {
            $query->where('employment_status', $request->employment_status);
        }

        $faculties = $query->orderBy('full_name')->paginate(15);

        return view('faculties.index', compact('faculties'));
    }

    public function create()
    {
        $subjects = Subject::active()->orderBy('code')->get();
        $users = User::whereNull('faculty_id')->where('role', 'faculty')->orderBy('name')->get();
        return view('faculties.create', compact('subjects', 'users'));
    }

    public function store(StoreFacultyRequest $request)
    {
        $faculty = Faculty::create($request->validated());

        if ($request->filled('qualifications')) {
            $faculty->qualifications()->sync($request->qualifications);
        }

        if ($request->filled('user_id')) {
            User::where('id', $request->user_id)->update(['faculty_id' => $faculty->faculty_id]);
        }

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty created successfully.');
    }

    public function show(Faculty $faculty)
    {
        $faculty->load(['qualifications', 'user', 'schedules.subject', 'schedules.section']);
        return view('faculties.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        $subjects = Subject::active()->orderBy('code')->get();
        $faculty->load('qualifications');
        $users = User::where(function ($q) use ($faculty) {
            $q->whereNull('faculty_id')->orWhere('faculty_id', $faculty->faculty_id);
        })->where('role', 'faculty')->orderBy('name')->get();
        return view('faculties.edit', compact('faculty', 'subjects', 'users'));
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $faculty->update($request->validated());

        if ($request->has('qualifications')) {
            $faculty->qualifications()->sync($request->qualifications ?? []);
        }

        User::where('faculty_id', $faculty->faculty_id)->update(['faculty_id' => null]);

        if ($request->filled('user_id')) {
            User::where('id', $request->user_id)->update(['faculty_id' => $faculty->faculty_id]);
        }

        return redirect()->route('faculties.index')
            ->with('success', 'Faculty updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->user()?->update(['faculty_id' => null]);
        $faculty->delete();
        return redirect()->route('faculties.index')
            ->with('success', 'Faculty deleted successfully.');
    }
}
