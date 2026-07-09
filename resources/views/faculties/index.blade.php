<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Faculties</h2>
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
                            <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <select name="employment_status" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">All Status</option>
                                <option value="full-time" {{ request('employment_status') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ request('employment_status') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                            </select>
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Filter</button>
                        </form>
                        <a href="{{ route('faculties.create') }}" class="bg-golden-500 hover:bg-golden-600 text-white font-bold py-2 px-4 rounded">Add Faculty</a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Specialization</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">User Account</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($faculties as $faculty)
                            <tr class="hover:bg-golden-50">
                                <td class="px-6 py-4">{{ $faculty->full_name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded {{ $faculty->employment_status == 'full-time' ? 'bg-green-100 text-green-800' : 'bg-golden-100 text-golden-800' }}">
                                        {{ ucfirst($faculty->employment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $faculty->academic_rank ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $faculty->specialization ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $faculty->user->email ?? 'Not linked' }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('faculties.show', $faculty) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded text-xs">Show</a>
                                    <a href="{{ route('faculties.edit', $faculty) }}" class="bg-golden-500 hover:bg-golden-600 text-white py-1 px-3 rounded text-xs">Edit</a>
                                    <form action="{{ route('faculties.destroy', $faculty) }}" method="POST" onsubmit="return confirm('Delete this faculty?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No faculties found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $faculties->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
