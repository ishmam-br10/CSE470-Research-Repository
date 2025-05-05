@extends('layout')

@section('content')
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl">Papers</h1>
        <a href="{{ route('papers.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Add Paper</a>
    </div>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="p-2 text-left">Title</th>
                <th class="p-2">Type</th>
                <th class="p-2">Year</th>
                <th class="p-2">Citations</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($papers as $paper)
            <tr class="border-t">
                <td class="p-2">{{ $paper->title }}</td>
                <td class="p-2 text-center">{{ $paper->type }}</td>
                <td class="p-2 text-center">{{ $paper->year }}</td>
                <td class="p-2 text-center">{{ $paper->cited }}</td>
                <!-- <td class="p-2">
                    <a href="{{ route('papers.edit',$paper) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('papers.destroy',$paper) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td> -->
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $papers->links() }}
    </div>
@endsection
