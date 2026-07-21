<x-app-layout title="Account Settings">
    <x-client-layout active="account-settings">
        <section class="section-card p-10 max-w-5xl mx-auto">
            <div class="mb-10">
                <h1 class="page-title">Account Settings</h1>
                <p class="section-subtitle mt-4">Update your profile, change your password, and keep your contact details current.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-100 text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-3xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-100 text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-3xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-100 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr] gap-8 items-center mb-10">
                <div class="flex items-center gap-6">
                    <div class="relative">
                        @php
                            $profileImage = $user->profile_image && \Storage::disk('public')->exists($user->profile_image)
                                ? asset('storage/' . $user->profile_image)
                                : null;
                        @endphp

                        @if($profileImage)
                            <img src="{{ $profileImage }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-white/20 shadow-lg">
                        @else
                            <div class="w-24 h-24 rounded-full bg-white/10 flex items-center justify-center border-4 border-white/20 shadow-lg">
                                <i class="fa-solid fa-user text-white text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-white font-semibold text-2xl">{{ $user->name }}</h2>
                        <p class="text-white/70 text-sm">Client Profile</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('account-settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="block">
                        <span class="text-white font-semibold">First Name</span>
                        <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name', $user->first_name) }}" required class="form-control mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-white font-semibold">Last Name</span>
                        <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}" required class="form-control mt-2" />
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="block">
                        <span class="text-white font-semibold">Email</span>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required class="form-control mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-white font-semibold">Contact Number</span>
                        <input type="text" name="mobile_number" placeholder="Contact Number" value="{{ old('mobile_number', $user->mobile_number) }}" class="form-control mt-2" />
                    </label>
                </div>

                <label class="block">
                    <span class="text-white font-semibold">Address</span>
                    <input type="text" name="address" placeholder="Address" value="{{ old('address', $user->address) }}" class="form-control mt-2" />
                </label>

                <div>
                    <h2 class="text-white font-semibold text-xl mb-4">Security</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <label class="block">
                            <span class="text-white font-semibold">Current Password</span>
                            <input type="password" name="current_password" placeholder="Current Password" class="form-control mt-2" />
                        </label>
                        <label class="block">
                            <span class="text-white font-semibold">New Password</span>
                            <input type="password" name="new_password" placeholder="New Password" class="form-control mt-2" />
                        </label>
                        <label class="block">
                            <span class="text-white font-semibold">Confirm Password</span>
                            <input type="password" name="new_password_confirmation" placeholder="Confirm New Password" class="form-control mt-2" />
                        </label>
                    </div>
                </div>

                <label class="block">
                    <span class="text-white font-semibold">Profile Image</span>
                    <input type="file" name="profile_image" accept="image/*" class="form-control mt-2" />
                </label>

                <button type="submit" class="btn-primary w-full justify-center">Save Changes</button>
            </form>
        </section>
    </x-client-layout>
</x-app-layout>
