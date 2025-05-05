<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Paper') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('admin.papers.update', $paper) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-label for="title" value="{{ __('Title') }}" />
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $paper->title)" required />
                            <x-input-error for="title" class="mt-2" />
                        </div>

                        <div>
                            <x-label for="abstract" value="{{ __('Abstract') }}" />
                            <textarea id="abstract" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="abstract" rows="5" required>{{ old('abstract', $paper->abstract) }}</textarea>
                            <x-input-error for="abstract" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-label for="type" value="{{ __('Type') }}" />
                                <select id="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="type">
                                    <option value="journal" {{ old('type', $paper->type) === 'journal' ? 'selected' : '' }}>Journal</option>
                                    <option value="conference" {{ old('type', $paper->type) === 'conference' ? 'selected' : '' }}>Conference</option>
                                    <option value="book" {{ old('type', $paper->type) === 'book' ? 'selected' : '' }}>Book</option>
                                    <option value="other" {{ old('type', $paper->type) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error for="type" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="year" value="{{ __('Year') }}" />
                                <x-input id="year" class="block mt-1 w-full" type="number" name="year" min="1900" max="{{ date('Y')+1 }}" :value="old('year', $paper->year)" required />
                                <x-input-error for="year" class="mt-2" />
                            </div>

                            <div>
                                <x-label for="cited" value="{{ __('Citations') }}" />
                                <x-input id="cited" class="block mt-1 w-full" type="number" name="cited" min="0" :value="old('cited', $paper->cited)" />
                                <x-input-error for="cited" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-label for="authors" value="{{ __('Authors') }}" />
                            <select id="authors" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="authors[]" multiple>
                                @foreach($researchers as $researcher)
                                    <option value="{{ $researcher->id }}" {{ in_array($researcher->id, old('authors', $paper->authors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $researcher->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple authors</p>
                            <x-input-error for="authors" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update Paper') }}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>