<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-1">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Room Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $room->room_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Building</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $room->building ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $room->capacity }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Room Type</dt>
                                <dd class="mt-1 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $room->room_type === 'lab' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($room->room_type) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm">
                                    @if ($room->is_archived)
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Archived</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                        <div class="flex gap-2">
                            <a href="{{ route('rooms.edit', $room) }}"
                               class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Edit
                            </a>
                            <a href="{{ route('rooms.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Back
                            </a>
                        </div>
                    </div>

                    @if (isset($room->schedules) && $room->schedules->isNotEmpty())
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedules</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Section</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($room->schedules as $schedule)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->section->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $schedule->subject ?? 'N/A' }}</td>
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
                            No schedules assigned to this room.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
