<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Generate Schedule</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('schedules.generate') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Academic Year</label>
                            <input type="text" name="academic_year" value="{{ old('academic_year', date('Y').'-'.(date('Y')+1)) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            @error('academic_year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Semester</label>
                            <select name="semester" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                <option value="1st">1st Semester</option>
                                <option value="2nd">2nd Semester</option>
                                <option value="summer">Summer</option>
                            </select>
                            @error('semester') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Generate</button>
                            <a href="{{ route('schedules.index') }}" class="text-primary-600 hover:text-primary-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
