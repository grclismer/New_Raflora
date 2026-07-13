<x-app-layout title="Reset Password">
    <x-auth-layout>
        <div class="w-full max-w-md glass-card p-10">
            <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-2">RESET PASSWORD</h1>
            <p class="text-white/60 text-center text-sm mb-8">Set a new password for your account.</p>

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

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                @if(!empty($fullName))
                    <div class="mb-6 text-center">
                        <p class="text-sm text-white/70 uppercase tracking-[0.25em]">Reset password for</p>
                        <p class="text-white text-xl font-semibold">{{ $fullName }}</p>
                    </div>
                @endif

                <div>
                    <label for="password" class="sr-only">New Password</label>
                    <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.73a1.5 1.5 0 0 0-1.5-1.5h-9A1.5 1.5 0 0 0 4.5 6.73V10.5m11.25 5.25v-4.5a1.5 1.5 0 0 0-1.5-1.5h-9a1.5 1.5 0 0 0-1.5 1.5v4.5m11.25 5.25v.625A2.625 2.625 0 0 1 20.625 19.5H3.375A2.625 2.625 0 0 1 .75 17.125v-.625" />
                        </svg>
                        <input type="password" name="password" id="password" placeholder="New Password" class="auth-input" required>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="sr-only">Confirm New Password</label>
                    <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.73a1.5 1.5 0 0 0-1.5-1.5h-9A1.5 1.5 0 0 0 4.5 6.73V10.5m11.25 5.25v-4.5a1.5 1.5 0 0 0-1.5-1.5h-9a1.5 1.5 0 0 0-1.5 1.5v4.5m11.25 5.25v.625A2.625 2.625 0 0 1 20.625 19.5H3.375A2.625 2.625 0 0 1 .75 17.125v-.625" />
                        </svg>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="auth-input" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-white text-gray-900 font-semibold py-3 rounded-md hover:bg-white/90 transition uppercase tracking-wide">
                    Save New Password
                </button>

                <p class="text-center text-white/60 text-sm">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="text-white font-semibold hover:underline ml-1">Login</a>
                </p>
            </form>
        </div>
    </x-auth-layout>
</x-app-layout>
