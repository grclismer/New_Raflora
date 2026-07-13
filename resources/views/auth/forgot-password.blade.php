<x-app-layout title="Forgot Password">
    <x-auth-layout>
        <div class="w-full max-w-md glass-card p-10">
            <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-2">FORGOT PASSWORD</h1>
            <p class="text-white/60 text-center text-sm mb-8">No worries. Enter your email and we'll send you a reset link.</p>

            @if(session('status'))
                <div class="mb-6 p-3 rounded-lg bg-green-900/50 border border-green-500 text-green-300 text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-3 rounded-lg bg-red-900/50 border border-red-500 text-red-300 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="sr-only">Email Address</label>
                    <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email Address" class="auth-input" required autofocus>
                    </div>
                </div>

                <button type="submit" class="w-full bg-white text-gray-900 font-semibold py-3 rounded-md hover:bg-white/90 transition uppercase tracking-wide">
                    Reset Password
                </button>

                <p class="text-center text-white/60 text-sm">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-white font-semibold hover:underline ml-1">Login</a>
                </p>
            </form>
        </div>
    </x-auth-layout>
</x-app-layout>
