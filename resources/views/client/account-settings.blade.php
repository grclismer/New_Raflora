<x-app-layout title="Account Settings">
    <x-client-layout active="account-settings">
        <div class="max-w-5xl mx-auto">
            <h1 class="serif text-3xl font-bold text-white mb-6">Account Settings</h1>
            <div class="card-solid p-6">
                @if(session('success'))
                    <div class="mb-6 p-3 rounded-lg bg-green-900/50 border border-green-500 text-green-300 text-sm text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-3 rounded-lg bg-red-900/50 border border-red-500 text-red-300 text-sm text-center">
                        {{ session('error') }}
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

                <div class="flex items-center gap-6 mb-8">
                    <div class="relative">
                        @php
                            $profileImage = $user->profile_image && \Storage::disk('public')->exists($user->profile_image)
                                ? asset('storage/' . $user->profile_image)
                                : null;
                        @endphp

                        @if($profileImage)
                            <img src="{{ $profileImage }}" alt="Profile" class="w-24 h-24 rounded-full object-cover border-2 border-purple-400">
                        @else
                            <div class="w-24 h-24 rounded-full bg-purple-700 flex items-center justify-center border-2 border-purple-400">
                                <i class="fa-solid fa-user text-white text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-white font-semibold text-lg">{{ $user->name }}</h2>
                        <p class="text-white/60 text-sm">Client</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('account-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group form-group-icon">
                            <input type="text" value="User ID: {{ $user->id }}" readonly class="form-input readonly-input">
                            <i class="fa fa-id-card-clip form-icon"></i>
                        </div>
                        <div class="form-group form-group-icon">
                            <input type="text" value="{{ $user->username ?? 'Not set' }}" readonly class="form-input readonly-input">
                            <i class="fa fa-user form-icon"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group form-group-icon">
                            <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name', $user->first_name) }}" required class="form-input">
                            <i class="fa-solid fa-signature form-icon"></i>
                        </div>
                        <div class="form-group form-group-icon">
                            <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}" required class="form-input">
                            <i class="fa-solid fa-signature form-icon"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group form-group-icon">
                            <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required class="form-input">
                            <i class="fa fa-envelope form-icon"></i>
                        </div>
                        <div class="form-group form-group-icon">
                            <input type="text" name="mobile_number" placeholder="Contact Number" value="{{ old('mobile_number', $user->mobile_number) }}" class="form-input">
                            <i class="fa-solid fa-phone form-icon"></i>
                        </div>
                    </div>

                    <div class="form-group form-group-icon">
                        <input type="text" name="address" placeholder="Address" value="{{ old('address', $user->address) }}" class="form-input">
                        <i class="fa-solid fa-map-location-dot form-icon"></i>
                    </div>

                    <div class="section-title security-title">Security</div>

                    <div class="password-section">
                        <h4 class="password-title">Change Password (Leave blank if not changing):</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="form-group form-group-icon">
                                <input type="password" name="current_password" placeholder="Current Password" class="form-input">
                                <i class="fa fa-lock form-icon"></i>
                            </div>
                            <div class="form-group form-group-icon">
                                <input type="password" name="new_password" placeholder="New Password" class="form-input">
                                <i class="fa fa-lock form-icon"></i>
                            </div>
                            <div class="form-group form-group-icon">
                                <input type="password" name="new_password_confirmation" placeholder="Confirm New Password" class="form-input">
                                <i class="fa fa-lock form-icon"></i>
                            </div>
                        </div>
                        @error('current_password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="section-title security-title">Profile Image</div>
                    <div class="form-group form-group-icon">
                        <input type="file" name="profile_image" accept="image/*" class="form-input">
                        <i class="fa-solid fa-image form-icon"></i>
                    </div>

                    <button type="submit" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </x-client-layout>
</x-app-layout>
