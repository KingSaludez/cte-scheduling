<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-blue-50 text-blue-700 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Create account</h2>
            <p class="text-gray-500 mt-1">Join CTE NEMSU Tagbina scheduling system</p>
        </div>

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Juan Dela Cruz"
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 placeholder:text-gray-400 text-gray-900 text-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all duration-200">
                <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com"
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 placeholder:text-gray-400 text-gray-900 text-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all duration-200">
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password"
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 placeholder:text-gray-400 text-gray-900 text-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all duration-200">
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password"
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 placeholder:text-gray-400 text-gray-900 text-sm focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all duration-200">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
            </div>
        </div>

        <button type="submit" class="mt-6 w-full py-3 px-4 bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-semibold text-sm rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Create account
        </button>

        <p class="text-center text-sm text-gray-500 mt-8">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Sign in</a>
        </p>
    </form>
</x-guest-layout>