<x-app-layout title="Register">
    <x-auth-layout>
        <div class="w-full max-w-xl glass-card p-10">
            <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-6">REGISTER</h1>

            <form method="POST" action="{{ route('register.attempt') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="sr-only">First Name</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <input type="text" name="first_name" id="first_name" placeholder="First Name" class="auth-input" required>
                        </div>
                    </div>

                    <div>
                        <label for="last_name" class="sr-only">Last Name</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="auth-input" required>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="username" class="sr-only">Username</label>
                    <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <input type="text" name="username" id="username" placeholder="Username" class="auth-input" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.73a1.5 1.5 0 0 0-1.5-1.5h-9A1.5 1.5 0 0 0 4.5 6.73V10.5m11.25 5.25v-4.5a1.5 1.5 0 0 0-1.5-1.5h-9a1.5 1.5 0 0 0-1.5 1.5v4.5m11.25 5.25v.625A2.625 2.625 0 0 1 20.625 19.5H3.375A2.625 2.625 0 0 1 .75 17.125v-.625" />
                            </svg>
                            <input type="password" name="password" id="password" placeholder="Password" class="auth-input" required>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.73a1.5 1.5 0 0 0-1.5-1.5h-9A1.5 1.5 0 0 0 4.5 6.73V10.5m11.25 5.25v-4.5a1.5 1.5 0 0 0-1.5-1.5h-9a1.5 1.5 0 0 0-1.5 1.5v4.5m11.25 5.25v.625A2.625 2.625 0 0 1 20.625 19.5H3.375A2.625 2.625 0 0 1 .75 17.125v-.625" />
                            </svg>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="auth-input" required>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="address" class="sr-only">Address</label>
                    <div class="flex items-start gap-3 border-b border-white/30 pb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <input type="text" name="address" id="address" placeholder="Address" class="auth-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <input type="email" name="email" id="email" placeholder="Email" class="auth-input" required>
                        </div>
                    </div>

                    <div>
                        <label for="mobile_number" class="sr-only">Mobile Number</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3.75 0v1.5a.75.75 0 0 0 .75.75h3a.75.75 0 0 0 .75-.75V1.5m-6.75 9h4.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 1 .75-.75Z" />
                            </svg>
                            <input type="text" name="mobile_number" id="mobile_number" placeholder="Mobile Number" class="auth-input">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-white text-gray-900 font-semibold py-3 rounded-md hover:bg-white/90 transition uppercase tracking-wide">
                    Register
                </button>

                <p class="text-center text-white/60 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-white font-semibold hover:underline ml-1">Login</a>
                </p>
            </form>
        </div>
    </x-auth-layout>
</x-app-layout>
