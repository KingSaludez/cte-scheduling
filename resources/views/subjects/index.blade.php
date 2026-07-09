<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subjects</h2>
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
                            <input type="text" name="search" placeholder="Search code or title..." value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <select name="year_level" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">All Years</option>
                                @for($i=1;$i<=6;$i++)<option value="{{$i}}" {{ request('year_level') == $i ? 'selected' : '' }}>{{$i}}</option>@endfor
                            </select>
                            <select name="semester" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">All Sem</option>
                                <option value="1st" {{ request('semester') == '1st' ? 'selected' : '' }}>1st</option>
                                <option value="2nd" {{ request('semester') == '2nd' ? 'selected' : '' }}>2nd</option>
                                <option value="summer" {{ request('semester') == 'summer' ? 'selected' : '' }}>Summer</option>
                            </select>
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                        </form>
                        <a href="{{ route('subjects.create') }}" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Add Subject</a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Units</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Year</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Program</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($subjects as $subject)
                            <tr class="hover:bg-golden-50">
                                <td class="px-6 py-4 font-mono">{{ $subject->code }}</td>
                                <td class="px-6 py-4">{{ $subject->title }}</td>
                                <td class="px-6 py-4">{{ $subject->units }}</td>
                                <td class="px-6 py-4">{{ $subject->year_level }}</td>
                                <td class="px-6 py-4">{{ $subject->semester }}</td>
                                <td class="px-6 py-4">{{ $subject->program ?? 'N/A' }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('subjects.show', $subject) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded text-xs">Show</a>
                                    <a href="{{ route('subjects.edit', $subject) }}" class="bg-golden-500 hover:bg-golden-600 text-white py-1 px-3 rounded text-xs">Edit</a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Delete this subject?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No subjects found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $subjects->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
