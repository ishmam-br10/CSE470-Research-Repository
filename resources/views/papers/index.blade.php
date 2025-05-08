<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Papers') }}
            </h2>
            <a href="{{ route('papers.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Add Paper') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
    <div class="w-full px-4">


            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Citations</th>
                                <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($papers as $paper)
                                <tr>
                                    <td class="px-6 py-4 whitespace-normal text-sm">
                                        <div class="text-gray-900 font-medium">{{ $paper->title }}</div>
                                        <div class="text-gray-500 text-xs mt-1">
                                            @if($paper->authors->count() > 0)
                                                {{ $paper->authors->pluck('name')->join(', ') }}
                                            @else
                                                No authors
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">{{ $paper->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">{{ $paper->year }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-900">{{ $paper->cited }}</td>
                                    <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        <a href="{{ route('papers.edit', $paper) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        <form action="{{ route('papers.destroy', $paper) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td> -->
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No papers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $papers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

