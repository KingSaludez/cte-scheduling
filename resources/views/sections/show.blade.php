<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Section Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-1">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $section->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Year Level</dt>
                                <dd class="mt-1 text-sm text-gray-900">Year {{ $section->year_level }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Student Count</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $section->student_count }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Semester</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($section->semester) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Academic Year</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $section->academic_year }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm">
                                    @if ($section->is_archived)
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Archived</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                        <div class="flex gap-2">
                            <a href="{{ route('sections.edit', $section) }}"
                               class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Edit
                            </a>
                            <a href="{{ route('sections.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Back
                            </a>
                        </div>
                    </div>

                    @if (isset($section->schedules) && $section->schedules->isNotEmpty())
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedules</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($section->schedules as $schedule)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->subject->code ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->room->room_number ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->day ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $schedule->start_time ?? 'N/A' }} - {{ $schedule->end_time ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 p-4 bg-gray-50 rounded-md text-center text-gray-500">
                            No schedules assigned to this section.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
