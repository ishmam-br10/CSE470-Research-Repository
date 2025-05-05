<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Profile Header -->
                    <div class="flex flex-col md:flex-row border-b pb-6 mb-6">
                        <!-- Image on the left - Changed to circular format like Google Scholar -->
                        <div class="md:w-1/4 flex justify-start items-start mb-4 md:mb-0">
                            @if($researcher->avatar_path)
                                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-200 shadow-sm">
                                    <img src="{{ Storage::url($researcher->avatar_path) }}" alt="{{ $researcher->name }}" 
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-16 h-16 bg-gray-300 flex items-center justify-center text-xl text-gray-700 border-2 border-gray-200 shadow-sm rounded-full">
                                    {{ substr($researcher->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Researcher details beside the image -->
                        <div class="md:w-4/5 md:pl-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h1 class="text-3xl font-bold mb-1">{{ $researcher->name }}</h1>
                                    <p class="text-lg text-gray-700 mb-2">{{ $researcher->department }}</p>
                                    <p class="text-gray-600 mb-4">{{ $researcher->contact }}</p>
                                    
                                    @if($researcher->bio)
                                        <p class="text-gray-800 mb-4">{{ $researcher->bio }}</p>
                                    @endif
                                </div>
                                
                                @if($isOwner)
                                    <a href="{{ route('researchers.editProfile', $researcher) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                                        Edit Profile
                                    </a>
                                @endif
                            </div>
                            
                            <!-- Citation Metrics -->
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-3 rounded border">
                                    <div class="text-2xl font-bold">{{ $totalCitations }}</div>
                                    <div class="text-sm text-gray-600">Citations</div>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded border">
                                    <div class="text-2xl font-bold">{{ $paperCount }}</div>
                                    <div class="text-sm text-gray-600">Publications</div>
                                </div>
                                
                                @if($paperCount > 0)
                                <div class="bg-gray-50 p-3 rounded border">
                                    <div class="text-2xl font-bold">{{ round($totalCitations / $paperCount, 1) }}</div>
                                    <div class="text-sm text-gray-600">Citations per paper</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Collaborators Section -->
                    @if(count($collaborators) > 0)
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-4">Collaborators</h2>
                        <div class="flex flex-wrap gap-3">
                            @foreach($collaborators as $collaborator)
                                <a href="{{ route('researchers.profile', $collaborator) }}" 
                                   class="flex items-center px-3 py-2 bg-gray-50 border rounded-md hover:bg-gray-100 transition">
                                    @if($collaborator->avatar_path)
                                        <div class="w-6 h-6 rounded-full overflow-hidden mr-2">
                                            <img src="{{ Storage::url($collaborator->avatar_path) }}" alt="{{ $collaborator->name }}" 
                                                class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center text-sm text-gray-700 mr-2">
                                            {{ substr($collaborator->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ $collaborator->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Publications List -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Publications</h2>
                            <div class="flex items-center gap-2">
                                <div class="text-sm text-gray-500">Articles 1-{{ $papers->count() }}</div>
                                <div class="relative inline-block">
                                    <button id="sortButton" class="text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded border flex items-center gap-1">
                                        <span>Sort</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div id="sortDropdown" class="hidden absolute right-0 mt-1 w-40 bg-white shadow-lg rounded-md border z-10">
                                        <a href="{{ route('researchers.profile', ['researcher' => $researcher->id, 'sort' => 'citations_desc']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-md">Most cited first</a>
                                        <a href="{{ route('researchers.profile', ['researcher' => $researcher->id, 'sort' => 'citations_asc']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Least cited first</a>
                                        <a href="{{ route('researchers.profile', ['researcher' => $researcher->id, 'sort' => 'year_desc']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Newest first</a>
                                        <a href="{{ route('researchers.profile', ['researcher' => $researcher->id, 'sort' => 'year_asc']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-md">Oldest first</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="w-8"></th>
                                    <th class="px-3 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">TITLE</th>
                                    <th class="px-3 py-2 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('researchers.profile', ['researcher' => $researcher->id, 'sort' => request('sort') == 'citations_asc' ? 'citations_desc' : 'citations_asc']) }}" class="flex items-center justify-center">
                                            CITED BY
                                            @if(request('sort') == 'citations_desc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            @elseif(request('sort') == 'citations_asc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-3 py-2 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('researchers.profile', ['researcher' => $researcher->id, 'sort' => request('sort') == 'year_asc' ? 'year_desc' : 'year_asc']) }}" class="flex items-center justify-center">
                                            YEAR
                                            @if(request('sort') == 'year_desc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            @elseif(request('sort') == 'year_asc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-3 py-2 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($papers as $index => $paper)
                                <tr>
                                    <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center">
                                            <span class="font-medium mr-2">{{ $paper->title }}</span>
                                            <a href="{{ route('papers.show', $paper) }}" class="text-blue-600 hover:bg-blue-100 rounded-full p-1" title="Download Paper">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $paper->researchers ? collect($paper->researchers->pluck('name'))->join(', ') : '' }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-center">
                                        <span class="text-sm font-medium">{{ $paper->cited }}</span>
                                    </td>
                                    <td class="px-3 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $paper->year }}</td>
                                    <td class="px-3 py-3 whitespace-nowrap text-center">
                                        <form action="{{ route('papers.cite', $paper) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-700 py-1 px-3 rounded text-xs font-medium border border-green-200 transition-colors duration-150 flex items-center justify-center mx-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Cite
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-4 text-center text-gray-500">
                                        No publications found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add JavaScript for the sort dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortButton = document.getElementById('sortButton');
            const sortDropdown = document.getElementById('sortDropdown');
            
            if (sortButton && sortDropdown) {
                sortButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    sortDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!sortButton.contains(e.target) && !sortDropdown.contains(e.target)) {
                        sortDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</x-app-layout>