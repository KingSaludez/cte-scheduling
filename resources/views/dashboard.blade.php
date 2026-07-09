<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($stats))
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-primary-500">
                        <div class="text-3xl font-bold text-primary-600">{{ $stats['faculty_count'] }}</div>
                        <div class="text-sm text-gray-500">Faculty</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-primary-500">
                        <div class="text-3xl font-bold text-primary-600">{{ $stats['subject_count'] }}</div>
                        <div class="text-sm text-gray-500">Subjects</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-primary-500">
                        <div class="text-3xl font-bold text-primary-600">{{ $stats['section_count'] }}</div>
                        <div class="text-sm text-gray-500">Sections</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-primary-500">
                        <div class="text-3xl font-bold text-primary-600">{{ $stats['room_count'] }}</div>
                        <div class="text-sm text-gray-500">Rooms</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-golden-500">
                        <div class="text-3xl font-bold text-golden-600">{{ $stats['draft_schedules'] + $stats['generated_schedules'] }}</div>
                        <div class="text-sm text-gray-500">Pending Schedules</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-green-500">
                        <div class="text-3xl font-bold text-green-600">{{ $stats['finalized_schedules'] }}</div>
                        <div class="text-sm text-gray-500">Finalized</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-primary-800">Schedule Status Overview</h3>
                    @php $total = $stats['draft_schedules'] + $stats['generated_schedules'] + $stats['reviewed_schedules'] + $stats['approved_schedules'] + $stats['finalized_schedules']; @endphp
                    <div class="space-y-2">
                        @foreach(['draft', 'generated', 'reviewed', 'approved', 'finalized'] as $status)
                            <div class="flex items-center">
                                <span class="w-32 text-sm text-gray-600">{{ ucfirst($status) }}</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-4">
                                    <div class="h-4 rounded-full {{ $status === 'finalized' ? 'bg-green-500' : ($status === 'approved' ? 'bg-primary-500' : 'bg-golden-400') }}" style="width: {{ $total > 0 ? round(($stats[$status.'_schedules'] / $total) * 100) : 0 }}%"></div>
                                </div>
                                <span class="ml-2 text-sm font-medium">{{ $stats[$status.'_schedules'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-primary-500">
                        <h3 class="text-lg font-semibold mb-4 text-primary-800">My Load Summary</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between"><dt class="text-gray-600">Total Units</dt><dd class="font-bold text-primary-600">{{ $load['total_units'] }}</dd></div>
                            <div class="flex justify-between"><dt class="text-gray-600">Max Load</dt><dd class="font-bold">{{ $load['max_load'] }}</dd></div>
                            <div class="flex justify-between"><dt class="text-gray-600">Remaining</dt><dd class="font-bold text-green-600">{{ $load['remaining'] }}</dd></div>
                            <div class="flex justify-between"><dt class="text-gray-600">Classification</dt><dd><span class="px-2 py-1 text-xs rounded {{ $load['classification'] == 'regular' ? 'bg-green-100 text-green-800' : ($load['classification'] == 'overload' ? 'bg-golden-100 text-golden-800' : 'bg-red-100 text-red-800') }} capitalize">{{ $load['classification'] }}</span></dd></div>
                            <div class="flex justify-between"><dt class="text-gray-600">Schedules</dt><dd class="font-bold">{{ $load['schedule_count'] }}</dd></div>
                        </dl>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-golden-500">
                        <h3 class="text-lg font-semibold mb-4 text-golden-700">Weekly Schedule</h3>
                        @forelse($weeklySchedule as $day => $daySchedules)
                            <div class="mb-3">
                                <h4 class="font-medium text-primary-700">{{ $day }}</h4>
                                @foreach($daySchedules as $s)
                                    <div class="text-sm text-gray-600 ml-2 border-l-2 border-primary-300 pl-2 my-1">{{ $s->start_time }}-{{ $s->end_time }} | {{ $s->subject->code ?? 'N/A' }} | {{ $s->section->name ?? 'N/A' }} | {{ $s->room->room_number ?? 'N/A' }}</div>
                                @endforeach
                            </div>
                        @empty
                            <p class="text-gray-500">No schedules assigned.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
