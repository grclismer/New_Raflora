<x-app-layout title="Login">
    <x-auth-layout>
        <div class="w-full max-w-md glass-card p-10">
            <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-2">WELCOME BACK</h1>
            <p class="text-white/60 text-center text-sm mb-8">Sign in to your account</p>

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="username" class="sr-only">Username</label>
                    <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <input type="text" name="username" id="username" placeholder="Username" class="auth-input" required autofocus>
                    </div>
                </div>

                <div>
                    <label for="password" class="sr-only">Password</label>
                    <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.73a1.5 1.5 0 0 0-1.5-1.5h-9A1.5 1.5 0 0 0 4.5 6.73V10.5m11.25 5.25v-4.5a1.5 1.5 0 0 0-1.5-1.5h-9a1.5 1.5 0 0 0-1.5 1.5v4.5m11.25 5.25v.625A2.625 2.625 0 0 1 20.625 19.5H3.375A2.625 2.625 0 0 1 .75 17.125v-.625" />
                        </svg>
                        <input type="password" name="password" id="password" placeholder="Password" class="auth-input" required>
                    </div>
                </div>

                <div class="text-right">
                    <a href="{{ route('forgot-password') }}" class="text-sm text-white/60 hover:text-white transition">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full bg-white text-gray-900 font-semibold py-3 rounded-md hover:bg-white/90 transition uppercase tracking-wide">
                    Login
                </button>

                <p class="text-center text-white/60 text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-white font-semibold hover:underline ml-1">Register</a>
                </p>
            </form>
        </div>
    </x-auth-layout>
</x-app-layout>
