<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex">
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden items-center justify-center bg-gradient-to-br from-blue-700 via-blue-800 to-blue-950">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-40 -left-40 w-80 h-80 bg-amber-400 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 right-10 w-60 h-60 bg-blue-300 rounded-full blur-3xl"></div>
                    <div class="absolute top-1/3 left-1/4 w-40 h-40 bg-white rounded-full blur-2xl"></div>
                </div>
                <div class="relative z-10 text-center px-12">
                    <x-application-logo class="w-32 h-32 mx-auto text-white mb-6 drop-shadow-xl" />
                    <h1 class="text-4xl font-bold text-white mb-3">CTE NEMSU Tagbina</h1>
                    <p class="text-xl text-blue-200 font-light">Instructor Scheduling System</p>
                    <div class="mt-12 border-t border-white/10 pt-8">
                        <p class="text-blue-300 text-sm italic">"Streamlining faculty schedules with efficiency and precision."</p>
                    </div>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
                <div class="w-full max-w-md">
                    <div class="lg:hidden text-center mb-8">
                        <x-application-logo class="w-20 h-20 mx-auto text-blue-700 mb-3" />
                        <h1 class="text-2xl font-bold text-gray-900">CTE NEMSU Tagbina</h1>
                        <p class="text-sm text-gray-500">Instructor Scheduling System</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                    <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} CTE NEMSU Tagbina</p>
                </div>
            </div>
        </div>
    </body>
</html>