<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Room</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('rooms.update', $room) }}">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Room Number</label>
                                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                @error('room_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Building</label>
                                <input type="text" name="building" value="{{ old('building', $room->building) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Capacity</label>
                                <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Room Type</label>
                                <select name="room_type" class="rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 shadow-sm w-full mt-1" required>
                                    <option value="lecture" {{ old('room_type', $room->room_type) == 'lecture' ? 'selected' : '' }}>Lecture</option>
                                    <option value="lab" {{ old('room_type', $room->room_type) == 'lab' ? 'selected' : '' }}>Lab</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            <a href="{{ route('rooms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
