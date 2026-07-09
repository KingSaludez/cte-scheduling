<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Schedule Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if($errors->has('status'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $errors->first('status') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-primary-500">
                    <dl class="space-y-3">
                        <div><dt class="text-sm font-medium text-gray-500">Faculty</dt><dd class="mt-1">{{ $schedule->faculty->full_name ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Subject</dt><dd class="mt-1">{{ $schedule->subject->code ?? 'N/A' }} - {{ $schedule->subject->title ?? '' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Section</dt><dd class="mt-1">{{ $schedule->section->name ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Room</dt><dd class="mt-1">{{ $schedule->room->room_number ?? 'N/A' }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Day</dt><dd class="mt-1">{{ $schedule->day }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Time</dt><dd class="mt-1">{{ $schedule->start_time }} - {{ $schedule->end_time }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Status</dt><dd class="mt-1"><span class="px-2 py-1 text-xs rounded {{ $schedule->status === 'finalized' ? 'bg-green-100 text-green-800' : ($schedule->status === 'approved' ? 'bg-primary-100 text-primary-800' : 'bg-golden-100 text-golden-800') }}">{{ ucfirst($schedule->status) }}</span></dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Semester</dt><dd class="mt-1">{{ $schedule->semester }} Semester</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Academic Year</dt><dd class="mt-1">{{ $schedule->academic_year }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500">Created By</dt><dd class="mt-1">{{ $schedule->creator->name ?? 'N/A' }}</dd></div>
                        @if($schedule->notes)<div><dt class="text-sm font-medium text-gray-500">Notes</dt><dd class="mt-1">{{ $schedule->notes }}</dd></div>@endif
                    </dl>
                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('schedules.edit', $schedule) }}" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href="{{ route('schedules.index') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Back</a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-golden-500">
                    <h3 class="text-lg font-semibold mb-4 text-golden-700">Update Status</h3>
                    <form method="POST" action="{{ route('schedules.status', $schedule) }}">
                        @csrf @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Current: <span class="font-normal">{{ ucfirst($schedule->status) }}</span></label>
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="draft" @selected($schedule->status == 'draft')>Draft</option>
                                <option value="generated" @selected($schedule->status == 'generated')>Generated</option>
                                <option value="reviewed" @selected($schedule->status == 'reviewed')>Reviewed</option>
                                <option value="approved" @selected($schedule->status == 'approved')>Approved</option>
                                <option value="finalized" @selected($schedule->status == 'finalized')>Finalized</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
