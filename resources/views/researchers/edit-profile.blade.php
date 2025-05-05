<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('researchers.updateProfile', $researcher) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $researcher->name)" required autofocus />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="department" value="{{ __('Department') }}" />
                            <x-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department', $researcher->department)" required />
                            @error('department')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="contact" value="{{ __('Contact Information') }}" />
                            <x-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact', $researcher->contact)" required />
                            <p class="text-gray-500 text-xs mt-1">Email, phone number, or other contact information</p>
                            @error('contact')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="bio" value="{{ __('Bio') }}" />
                            <textarea id="bio" name="bio" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('bio', $researcher->bio) }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Briefly describe your research interests and background</p>
                            @error('bio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="avatar" value="{{ __('Profile Photo') }}" />
                            
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
                            <p class="text-gray-500 text-xs mt-1">Upload a professional profile picture (optional)</p>
                            @error('avatar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('researchers.profile', $researcher) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition mr-2">
                                Cancel
                            </a>
                            <x-button type="submit">
                                {{ __('Save Changes') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>