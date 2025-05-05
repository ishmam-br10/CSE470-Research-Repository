@extends('layout')

@section('content')
    <h1 class="text-2xl mb-4">Add Paper</h1>
    <form action="{{ route('papers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block">Title</label>
            <input type="text" name="title" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Type</label>
            <input type="text" name="type" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">Year</label>
            <input type="number" name="year" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block">PDF File</label>
            <input type="file" name="file" accept="application/pdf" required>
        </div>
        <div>
            <label class="block">Authors</label>
            <select name="authors[]" multiple class="border rounded w-full p-2">
                @foreach($researchers as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
@endsection
