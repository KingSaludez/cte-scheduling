<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Schedule</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($errors->has('conflict'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{!! $errors->first('conflict') !!}</div>
                    @endif

                    <form method="POST" action="{{ route('schedules.update', $schedule) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Faculty</label>
                                <select name="faculty_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->faculty_id }}" @selected(old('faculty_id', $schedule->faculty_id) == $faculty->faculty_id)>{{ $faculty->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                                <select name="subject_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" @selected(old('subject_id', $schedule->subject_id) == $subject->id)>{{ $subject->code }} - {{ $subject->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Section</label>
                                <select name="section_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" @selected(old('section_id', $schedule->section_id) == $section->id)>{{ $section->name }} (Year {{ $section->year_level }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Room</label>
                                <select name="room_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" @selected(old('room_id', $schedule->room_id) == $room->id)>{{ $room->room_number }} ({{ ucfirst($room->room_type) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Day</label>
                                <select name="day" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    @foreach($days as $day)
                                        <option value="{{ $day }}" @selected(old('day', $schedule->day) == $day)>{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Start Time</label>
                                <input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">End Time</label>
                                <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                                <textarea name="notes" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-2">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update Schedule</button>
                            <a href="{{ route('schedules.show', $schedule) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
