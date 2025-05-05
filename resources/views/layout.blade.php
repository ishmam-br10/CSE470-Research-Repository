<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'BRACU Repo') }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-2 flex justify-between">
            <a href="{{ url('/') }}" class="text-xl font-semibold">BRACU Repo</a>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="mr-4">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button>Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
