<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Section::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('year_level')) {
            $query->where('year_level', $request->year_level);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $sections = $query->orderBy('name')->paginate(15);

        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(StoreSectionRequest $request)
    {
        Section::create($request->validated());

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function show(Section $section)
    {
        $section->load('schedules.subject', 'schedules.faculty');
        return view('sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $section->update($request->validated());

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully.');
    }
}
