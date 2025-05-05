<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Researcher Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/4 flex justify-center mb-6 md:mb-0">
                            @if($researcher->avatar)
                                <img src="{{ Storage::url($researcher->avatar) }}" alt="{{ $researcher->name }}" class="h-48 w-48 rounded-full object-cover">
                            @else
                                <div class="h-48 w-48 rounded-full bg-gray-300 flex items-center justify-center text-4xl text-gray-700">
                                    {{ substr($researcher->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="md:w-3/4 md:pl-8">
                            <h1 class="text-2xl font-bold mb-4">{{ $researcher->name }}</h1>
                            
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Department</h3>
                                <p>{{ $researcher->department }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2">Contact</h3>
                                <p>{{ $researcher->contact }}</p>
                            </div>
                            
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-4">Research Papers</h3>
                                @if($researcher->papers->count() > 0)
                                    <ul class="list-disc pl-5">
                                        @foreach($researcher->papers as $paper)
                                            <li class="mb-2">
                                                <a href="{{ route('papers.show', $paper) }}" class="text-blue-600 hover:underline">
                                                    {{ $paper->title }} ({{ $paper->year }})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">No research papers available.</p>
                                @endif
                            </div>
                            
                            <div class="mt-8 flex">
                                <a href="{{ route('researchers.edit', $researcher) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                    Edit Researcher
                                </a>
                                <a href="{{ route('researchers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>