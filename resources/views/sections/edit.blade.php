<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Section</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('sections.update', $section) }}">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Name</label>
                                <input type="text" name="name" value="{{ old('name', $section->name) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Year Level</label>
                                <select name="year_level" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    @for($i=1;$i<=6;$i++)<option value="{{$i}}" {{ old('year_level', $section->year_level) == $i ? 'selected' : '' }}>{{$i}}</option>@endfor
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Student Count</label>
                                <input type="number" name="student_count" value="{{ old('student_count', $section->student_count) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Semester</label>
                                <select name="semester" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    <option value="1st" {{ old('semester', $section->semester) == '1st' ? 'selected' : '' }}>1st</option>
                                    <option value="2nd" {{ old('semester', $section->semester) == '2nd' ? 'selected' : '' }}>2nd</option>
                                    <option value="summer" {{ old('semester', $section->semester) == 'summer' ? 'selected' : '' }}>Summer</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Academic Year</label>
                                <input type="text" name="academic_year" value="{{ old('academic_year', $section->academic_year) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            <a href="{{ route('sections.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
