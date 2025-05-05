<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply to Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">{{ $project->title }}</h3>
                        <p class="text-gray-600 mt-1">Led by: {{ $project->owner->name }}</p>
                    </div>
                    
                    <form action="{{ route('projects.applications.store', $project) }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <x-label for="motivation" value="{{ __('Why do you want to join this project?') }}" />
                            <textarea id="motivation" name="motivation" rows="6" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm" required>{{ old('motivation') }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Explain your interest in this project, your relevant skills, and how you could contribute.</p>
                            @error('motivation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-200 active:bg-gray-400 transition mr-2">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Submit Application') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>