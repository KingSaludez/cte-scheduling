<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sections</h2>
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
                            <input type="text" name="search" placeholder="Search name..." value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
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
                        <a href="{{ route('sections.create') }}" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Add Section</a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Year Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Students</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Academic Year</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($sections as $section)
                            <tr class="hover:bg-golden-50">
                                <td class="px-6 py-4">{{ $section->name }}</td>
                                <td class="px-6 py-4">{{ $section->year_level }}</td>
                                <td class="px-6 py-4">{{ $section->student_count }}</td>
                                <td class="px-6 py-4">{{ $section->semester }}</td>
                                <td class="px-6 py-4">{{ $section->academic_year }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('sections.show', $section) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded text-xs">Show</a>
                                    <a href="{{ route('sections.edit', $section) }}" class="bg-golden-500 hover:bg-golden-600 text-white py-1 px-3 rounded text-xs">Edit</a>
                                    <form action="{{ route('sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Delete this section?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No sections found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $sections->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
