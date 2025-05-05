<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Project Applications
            </h2>
            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 active:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Project
            </a>
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
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                        <p class="text-gray-600 mt-1">Led by: {{ $project->owner->name }}</p>
                    </div>

                    @if($applications->isEmpty())
                        <div class="bg-gray-50 border rounded-lg p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-4 text-lg text-gray-500">No applications yet for this project.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-200">
                            @foreach($applications as $application)
                                <div class="py-6 {{ !$loop->first ? 'pt-6' : '' }}">
                                    <div class="flex flex-col md:flex-row justify-between">
                                        <div class="mb-4 md:mb-0">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gray-300 text-center flex items-center justify-center text-gray-700 mr-3">
                                                    {{ substr($application->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-medium">{{ $application->user->name }}</h4>
                                                    <p class="text-gray-500 text-sm">Applied {{ $application->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            @if($application->status === 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full uppercase font-medium">Pending</span>
                                            @elseif($application->status === 'approved')
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase font-medium">Approved</span>
                                            @elseif($application->status === 'rejected')
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full uppercase font-medium">Rejected</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">Motivation:</h5>
                                        <p class="text-gray-600">{{ $application->motivation }}</p>
                                    </div>
                                    
                                    @if($application->status === 'pending')
                                        <div class="mt-4 flex space-x-3">
                                            <form action="{{ route('applications.updateStatus', $application) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-700 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('applications.updateStatus', $application) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-700 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>