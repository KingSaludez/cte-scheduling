<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Archive: {{ $archive->academic_year }} - {{ $archive->semester }} Semester</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Faculty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Section</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($archive->data as $entry)
                        <tr>
                            <td class="px-6 py-4">{{ $entry['faculty']['full_name'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $entry['subject']['code'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $entry['section']['name'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $entry['room']['room_number'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $entry['day'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ ($entry['start_time'] ?? '') . ' - ' . ($entry['end_time'] ?? '') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    <a href="{{ route('archives.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
