<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Subject</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('subjects.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Code</label>
                                <input type="text" name="code" value="{{ old('code') }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Title</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Units</label>
                                <input type="number" step="0.5" name="units" value="{{ old('units') }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('units') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Lecture Hours</label>
                                <input type="number" name="lecture_hours" value="{{ old('lecture_hours', 0) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('lecture_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Lab Hours</label>
                                <input type="number" name="lab_hours" value="{{ old('lab_hours', 0) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('lab_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Year Level</label>
                                <select name="year_level" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    <option value="">Select</option>
                                    @for($i=1;$i<=6;$i++)<option value="{{$i}}" {{ old('year_level') == $i ? 'selected' : '' }}>{{$i}}</option>@endfor
                                </select>
                                @error('year_level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Semester</label>
                                <select name="semester" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    <option value="">Select</option>
                                    <option value="1st" {{ old('semester') == '1st' ? 'selected' : '' }}>1st</option>
                                    <option value="2nd" {{ old('semester') == '2nd' ? 'selected' : '' }}>2nd</option>
                                    <option value="summer" {{ old('semester') == 'summer' ? 'selected' : '' }}>Summer</option>
                                </select>
                                @error('semester') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Program</label>
                                <input type="text" name="program" value="{{ old('program') }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">
                                @error('program') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Prerequisites</label>
                                <textarea name="prerequisites" rows="3" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">{{ old('prerequisites') }}</textarea>
                                @error('prerequisites') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Create</button>
                            <a href="{{ route('programs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
