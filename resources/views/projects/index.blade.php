<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projects') }}
            </h2>
            @if(Auth::user()->researcher)
                <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    {{ __('New Project') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if($projects->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="mt-4 text-lg text-gray-500">No projects available.</p>
                            @if(Auth::user()->researcher)
                                <div class="mt-6">
                                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                        {{ __('Create Your First Project') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($projects as $project)
                                <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="p-5 border-b">
                                        <h3 class="text-lg font-semibold text-gray-800 truncate">
                                            <a href="{{ route('projects.show', $project) }}" class="hover:text-blue-600">
                                                {{ $project->title }}
                                            </a>
                                        </h3>
                                        @if(Auth::check() && $project->isOwnedBy(Auth::user()) && $project->applications->where('status', 'pending')->count() > 0)
                                            <a href="{{ route('projects.applications.index', $project) }}" class="flex items-center justify-center bg-red-100 text-red-700 rounded-full px-2 py-1 text-xs font-semibold">
                                                {{ $project->applications->where('status', 'pending')->count() }} new
                                            </a>
                                        @endif
                                        </div>
                                        <div class="flex items-center mt-1 text-sm text-gray-600">
                                            <span class="inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $project->owner->name }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <span class="inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $project->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <p class="text-gray-600 line-clamp-3 mb-4 text-sm">{{ Str::limit($project->description, 150) }}</p>
                                        <div class="flex justify-between items-center pt-2">
                                            <span class="{{ 
                                                $project->status === 'ongoing' ? 'bg-green-100 text-green-800' : 
                                                ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') 
                                            }} text-xs px-2 py-1 rounded-full uppercase font-medium">
                                                {{ $project->status }}
                                            </span>
                                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                                View project
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>