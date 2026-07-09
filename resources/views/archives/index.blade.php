<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Semester Archives</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border-t-4 border-primary-500">
                <h3 class="text-lg font-semibold mb-4 text-primary-800">Archive a Semester</h3>
                <form method="POST" action="{{ route('archives.store') }}" class="flex gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Academic Year</label>
                        <input type="text" name="academic_year" value="{{ old('academic_year', date('Y').'-'.(date('Y')+1)) }}" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Semester</label>
                        <select name="semester" class="border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="summer">Summer</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Archive</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Academic Year</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Semester</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Archived At</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary-800 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($archives as $archive)
                            <tr class="hover:bg-golden-50">
                                <td class="px-6 py-4">{{ $archive->academic_year }}</td>
                                <td class="px-6 py-4">{{ $archive->semester }}</td>
                                <td class="px-6 py-4">{{ $archive->archived_at->format('M d, Y h:i A') }}</td>
                                <td class="px-6 py-4"><a href="{{ route('archives.show', $archive) }}" class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded text-xs">View</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No archives found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $archives->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
