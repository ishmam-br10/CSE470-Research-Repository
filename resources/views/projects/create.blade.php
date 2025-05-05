<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <x-label for="title" value="{{ __('Project Title') }}" />
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" name="description" rows="6" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Describe your project, its goals, and what kind of collaborators you're looking for.</p>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <x-label for="status" value="{{ __('Project Status') }}" />
                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="ongoing" selected>Ongoing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-200 active:bg-gray-400 transition mr-2">
                                {{ __('Cancel') }}
                            </a>
                            <x-button>
                                {{ __('Create Project') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>