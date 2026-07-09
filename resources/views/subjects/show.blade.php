<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subject Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><dt class="text-sm font-medium text-gray-500">Code</dt><dd class="mt-1 font-mono">{{ $subject->code }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Title</dt><dd class="mt-1">{{ $subject->title }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Units</dt><dd class="mt-1">{{ $subject->units }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Lecture Hours</dt><dd class="mt-1">{{ $subject->lecture_hours }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Lab Hours</dt><dd class="mt-1">{{ $subject->lab_hours }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Year Level</dt><dd class="mt-1">{{ $subject->year_level }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Semester</dt><dd class="mt-1">{{ $subject->semester }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Program</dt><dd class="mt-1">{{ $subject->program ?? 'N/A' }}</dd></div>
                        <div class="md:col-span-2"><dt class="text-sm font-medium text-gray-500">Prerequisites</dt><dd class="mt-1">{{ $subject->prerequisites ?? 'None' }}</dd></div>
                    </dl>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-primary-800">Qualified Faculties</h3>
                        @if($subject->qualifiedFaculties->isNotEmpty())
                            <ul class="mt-2 list-disc list-inside text-sm text-gray-600">
                                @foreach($subject->qualifiedFaculties as $faculty)
                                    <li>{{ $faculty->full_name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-1 text-sm text-gray-500">No qualified faculties.</p>
                        @endif
                    </div>

                    <div class="flex gap-2 mt-6">
                        <a href="{{ route('subjects.edit', $subject) }}" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href="{{ route('subjects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
