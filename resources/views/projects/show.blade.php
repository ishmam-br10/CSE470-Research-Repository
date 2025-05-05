<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project Details
            </h2>
            <div class="flex items-center">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 active:bg-gray-300 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Projects
                </a>
            </div>
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

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $project->title }}</h1>
                            <div class="flex items-center mt-2 text-gray-600">
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Lead Researcher: 
                                    <a href="{{ route('researchers.profile', $project->owner) }}" class="ml-1 text-blue-600 hover:underline">
                                        {{ $project->owner->name }}
                                    </a>
                                </span>
                                <span class="mx-3">•</span>
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Created: {{ $project->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <span class="{{ 
                                $project->status === 'ongoing' ? 'bg-green-100 text-green-800' : 
                                ($project->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') 
                            }} px-3 py-1 rounded-full text-sm font-medium uppercase">
                                {{ $project->status }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Project Description</h3>
                        <div class="prose max-w-none text-gray-600">
                            <p>{{ $project->description }}</p>
                        </div>
                    </div>

                    @if($project->researchers->count() > 1)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Collaborators</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($project->researchers->where('id', '!=', $project->owner->id) as $researcher)
                                    <a href="{{ route('researchers.profile', $researcher) }}" class="inline-flex items-center px-3 py-2 bg-gray-100 rounded-md hover:bg-gray-200 text-sm">
                                        <div class="w-6 h-6 rounded-full bg-gray-300 text-center text-gray-700 mr-2 flex items-center justify-center text-xs">
                                            {{ substr($researcher->name, 0, 1) }}
                                        </div>
                                        {{ $researcher->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        @if($isOwner)
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Project
                                </a>
                                
                                <a href="{{ route('projects.applications.index', $project) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    View Applications
                                    @if($project->applications->where('status', 'pending')->count() > 0)
                                        <span class="ml-2 bg-white text-green-700 rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold">
                                            {{ $project->applications->where('status', 'pending')->count() }}
                                        </span>
                                    @endif
                                </a>
                                
                                <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Project
                                    </button>
                                </form>
                            </div>
                        @elseif($isCollaborator ?? false)
                            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-600">
                                            You are a collaborator on this project.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif(!$hasApplied && $project->status === 'ongoing')
                            <a href="{{ route('projects.applications.create', $project) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Apply to Join
                            </a>
                        @elseif($hasApplied)
                            @if($applicationStatus === 'pending')
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-600">
                                                You've already applied to this project. The project owner will review your application soon.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($applicationStatus === 'approved')
                                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-600">
                                                Your application has been approved! You are now a collaborator on this project.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($applicationStatus === 'rejected')
                                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-600">
                                                Your application was not accepted for this project.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-600">
                                                You've already applied to this project. The project owner will review your application soon.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>