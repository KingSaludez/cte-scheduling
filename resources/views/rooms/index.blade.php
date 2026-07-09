<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rooms</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <form method="GET" class="flex gap-2">
                            <input type="text" name="search" placeholder="Search room/building..." value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <select name="room_type" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">All Types</option>
                                <option value="lecture" {{ request('room_type') == 'lecture' ? 'selected' : '' }}>Lecture</option>
                                <option value="lab" {{ request('room_type') == 'lab' ? 'selected' : '' }}>Lab</option>
                            </select>
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                        </form>
                        <a href="{{ route('rooms.create') }}" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Add Room</a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Building</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Capacity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($rooms as $room)
                            <tr class="hover:bg-golden-50">
                                <td class="px-6 py-4">{{ $room->room_number }}</td>
                                <td class="px-6 py-4">{{ $room->building ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $room->capacity }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded {{ $room->room_type == 'lecture' ? 'bg-primary-100 text-primary-800' : 'bg-golden-100 text-golden-800' }}">
                                        {{ ucfirst($room->room_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('rooms.show', $room) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded text-xs">Show</a>
                                    <a href="{{ route('rooms.edit', $room) }}" class="bg-golden-500 hover:bg-golden-600 text-white py-1 px-3 rounded text-xs">Edit</a>
                                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Delete this room?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No rooms found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $rooms->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
