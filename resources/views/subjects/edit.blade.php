<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Subject</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('subjects.update', $subject) }}">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Code</label>
                                <input type="text" name="code" value="{{ old('code', $subject->code) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Title</label>
                                <input type="text" name="title" value="{{ old('title', $subject->title) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Units</label>
                                <input type="number" step="0.5" name="units" value="{{ old('units', $subject->units) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('units') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Lecture Hours</label>
                                <input type="number" name="lecture_hours" value="{{ old('lecture_hours', $subject->lecture_hours) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">
                                @error('lecture_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Lab Hours</label>
                                <input type="number" name="lab_hours" value="{{ old('lab_hours', $subject->lab_hours) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">
                                @error('lab_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Year Level</label>
                                <select name="year_level" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    @for($i=1;$i<=6;$i++)<option value="{{$i}}" {{ old('year_level', $subject->year_level) == $i ? 'selected' : '' }}>{{$i}}</option>@endfor
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Semester</label>
                                <select name="semester" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    <option value="1st" {{ old('semester', $subject->semester) == '1st' ? 'selected' : '' }}>1st</option>
                                    <option value="2nd" {{ old('semester', $subject->semester) == '2nd' ? 'selected' : '' }}>2nd</option>
                                    <option value="summer" {{ old('semester', $subject->semester) == 'summer' ? 'selected' : '' }}>Summer</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Program</label>
                                <input type="text" name="program" value="{{ old('program', $subject->program) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Prerequisites</label>
                                <textarea name="prerequisites" rows="3" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">{{ old('prerequisites', $subject->prerequisites) }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            <a href="{{ route('programs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
