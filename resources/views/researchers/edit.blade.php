<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Researcher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('researchers.update', $researcher) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $researcher->name)" required autofocus />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="department" :value="__('Department')" />
                            <x-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department', $researcher->department)" required />
                            @error('department')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="contact" :value="__('Contact')" />
                            <x-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact', $researcher->contact)" required />
                            @error('contact')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="avatar" :value="__('Profile Photo')" />
                            
                            @if($researcher->avatar)
                                <div class="mt-2 mb-4">
                                    <span class="block text-sm font-medium text-gray-700 mb-1">Current Photo:</span>
                                    <img src="{{ Storage::url($researcher->avatar) }}" alt="{{ $researcher->name }}" class="h-24 w-24 rounded-full object-cover">
                                </div>
                            @endif
                            
                            <input id="avatar" type="file" name="avatar" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100" />
                            <p class="text-gray-500 text-xs mt-1">Leave empty to keep current photo</p>
                            @error('avatar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-4">
                            <x-button type="submit" class="ml-3">
                                {{ __('Update Researcher') }}
                            </x-button>
                            <a href="{{ route('researchers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>