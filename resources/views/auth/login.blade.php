<x-guest-layout>
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-blue-50 text-blue-700 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
            <p class="text-gray-500 mt-1">Sign in to your account to continue</p>
        </div>

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com"
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 placeholder:text-gray-400 text-gray-900 text-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 placeholder:text-gray-400 text-gray-900 text-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                <span class="text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="mt-6 w-full py-3 px-4 bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Sign in
        </button>

        <p class="text-center text-sm text-gray-500 mt-8">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Create one</a>
        </p>
    </form>
</x-guest-layout>