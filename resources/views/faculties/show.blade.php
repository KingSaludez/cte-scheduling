<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Faculty Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><dt class="text-sm font-medium text-gray-500">Full Name</dt><dd class="mt-1">{{ $faculty->full_name }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Gender</dt><dd class="mt-1">{{ ucfirst($faculty->gender) ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Employment Status</dt><dd class="mt-1"><span class="px-2 py-1 text-xs rounded {{ $faculty->employment_status == 'full-time' ? 'bg-green-100 text-green-800' : 'bg-golden-100 text-golden-800' }}">{{ ucfirst($faculty->employment_status) }}</span></dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Academic Rank</dt><dd class="mt-1">{{ $faculty->academic_rank ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Educational Attainment</dt><dd class="mt-1">{{ $faculty->educational_attainment ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Professional License</dt><dd class="mt-1">{{ $faculty->professional_license ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Specialization</dt><dd class="mt-1">{{ $faculty->specialization ?? 'N/A' }}</dd></div>
                    </dl>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-primary-800">User Account</h3>
                        @if($faculty->user)
                            <p class="mt-1 text-sm text-gray-600">Linked to: {{ $faculty->user->name }} ({{ $faculty->user->email }})</p>
                        @else
                            <p class="mt-1 text-sm text-gray-500">No user account linked.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-primary-800">Qualifications</h3>
                        @if($faculty->qualifications->isNotEmpty())
                            <ul class="mt-2 list-disc list-inside text-sm text-gray-600">
                                @foreach($faculty->qualifications as $subject)
                                    <li>{{ $subject->code }} - {{ $subject->title }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-1 text-sm text-gray-500">No qualifications assigned.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-primary-800">Assigned Schedules</h3>
                        @if($faculty->schedules->isNotEmpty())
                            <table class="mt-2 min-w-full divide-y divide-gray-200">
                                <thead class="bg-primary-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-primary-800 uppercase">Subject</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-primary-800 uppercase">Day</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-primary-800 uppercase">Time</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-primary-800 uppercase">Semester</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($faculty->schedules as $schedule)
                                        <tr>
                                            <td class="px-4 py-2 text-sm">{{ $schedule->subject->code ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $schedule->day }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $schedule->semester }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="mt-1 text-sm text-gray-500">No schedules assigned.</p>
                        @endif
                    </div>

                    <div class="flex gap-4 mt-6">
                        <a href="{{ route('faculties.edit', $faculty) }}" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href="{{ route('faculties.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
