<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Section</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('sections.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                                <label class="block font-medium text-sm text-gray-700">Student Count</label>
                                <input type="number" name="student_count" value="{{ old('student_count', 0) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('student_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Academic Year</label>
                                <input type="text" name="academic_year" value="{{ old('academic_year', date('Y').'-'.(date('Y')+1)) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('academic_year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            <a href="{{ route('sections.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
