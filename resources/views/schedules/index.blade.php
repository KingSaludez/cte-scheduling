<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Schedules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('schedules.create') }}" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Generate Schedule</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <input type="text" name="academic_year" placeholder="Academic Year" value="{{ request('academic_year') }}" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <select name="semester" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Semesters</option>
                            <option value="1st" @selected(request('semester') == '1st')>1st</option>
                            <option value="2nd" @selected(request('semester') == '2nd')>2nd</option>
                            <option value="summer" @selected(request('semester') == 'summer')>Summer</option>
                        </select>
                        <select name="status" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Status</option>
                            <option value="draft" @selected(request('status') == 'draft')>Draft</option>
                            <option value="generated" @selected(request('status') == 'generated')>Generated</option>
                            <option value="reviewed" @selected(request('status') == 'reviewed')>Reviewed</option>
                            <option value="approved" @selected(request('status') == 'approved')>Approved</option>
                            <option value="finalized" @selected(request('status') == 'finalized')>Finalized</option>
                        </select>
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                    </form>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Faculty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Day</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($schedules as $schedule)
                            <tr class="hover:bg-golden-50">
                                <td class="px-6 py-4">{{ $schedule->faculty->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $schedule->subject->code ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $schedule->section->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $schedule->room->room_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $schedule->day }}</td>
                                <td class="px-6 py-4">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded {{ $schedule->status === 'finalized' ? 'bg-green-100 text-green-800' : ($schedule->status === 'approved' ? 'bg-primary-100 text-primary-800' : 'bg-golden-100 text-golden-800') }}">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('schedules.show', $schedule) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded text-xs">Show</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No schedules found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $schedules->appends(request()->query())->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
