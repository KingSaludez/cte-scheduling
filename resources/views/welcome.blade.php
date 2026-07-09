<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'CTE NEMSU Tagbina') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
            <div class="text-center">
                <x-application-logo class="w-24 h-24 mx-auto text-indigo-600" />
                <h1 class="mt-6 text-4xl font-bold text-gray-800">CTE NEMSU Tagbina</h1>
                <p class="mt-2 text-lg text-gray-600">Instructor Scheduling System</p>
                <div class="mt-8 flex gap-4 justify-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
            <div class="mt-16 text-sm text-gray-400">&copy; {{ date('Y') }} CTE NEMSU Tagbina</div>
        </div>
    </body>
</html>