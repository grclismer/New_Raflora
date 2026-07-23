<x-app-layout title="Guest Booking">
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:p-10 rounded-2xl shadow-xl border border-slate-100">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-2">
                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1 rounded-full w-max">Guest Fast-Track Booking</span>
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">Have an account? Log in</a>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-2">Book Event Floral Services</h1>
                <p class="text-sm text-slate-500 mt-1 mb-8">No account required. Fill out the details below to receive your quotation.</p>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('guest.booking.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- 1. GUEST CONTACT DETAILS -->
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-4">1. Guest Contact Details</h3>
                        <div class="p-5 bg-slate-50/70 rounded-xl border border-slate-200/80">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Full Name *</label>
                                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" placeholder="Juan Dela Cruz" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Email Address *</label>
                                    <input type="email" name="guest_email" value="{{ old('guest_email') }}" placeholder="juan@example.com" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Mobile Phone Number *</label>
                                    <input type="tel" name="guest_phone" value="{{ old('guest_phone') }}" placeholder="+63 917 123 4567" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Physical Address (Optional)</label>
                                    <input type="text" name="guest_address" value="{{ old('guest_address') }}" placeholder="City / Barangay" class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. CHOOSE BOOKING METHOD -->
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3">2. Choose Booking Method</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- AI Card -->
                            <label id="guest-card-ai" onclick="switchGuestMode('ai')" class="relative flex items-start p-4 border-2 border-emerald-600 bg-emerald-50/30 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="booking_type" value="custom_ai" checked class="sr-only">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 mr-3 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Upload Custom Design (AI)</div>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-snug">Upload a photo of your dream arrangement and let AI generate an instant itemized breakdown.</p>
                                </div>
                            </label>

                            <!-- Preset Card -->
                            <label id="guest-card-preset" onclick="switchGuestMode('preset')" class="relative flex items-start p-4 border-2 border-slate-200 bg-white rounded-xl cursor-pointer transition-all hover:border-slate-300">
                                <input type="radio" name="booking_type" value="preset" class="sr-only">
                                <div id="preset-icon-box" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Select Curated Package</div>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-snug">Choose a fixed-price package crafted by our master florists without AI processing.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- DYNAMIC AI SECTION -->
                    <div id="guest-section-ai" class="p-6 bg-slate-50/60 rounded-xl border border-dashed border-emerald-300">
                        <label class="block text-xs font-bold text-slate-700 mb-3">Inspiration Image *</label>
                        <div id="guestDropzone" class="bg-white border border-dashed border-emerald-400 rounded-xl p-8 text-center cursor-pointer hover:bg-emerald-50/20 transition flex flex-col items-center justify-center">
                            <div id="guestImagePlaceholder" class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Upload your event photo or bouquet reference</p>
                                <p class="text-xs text-slate-400 mt-1">PNG, JPG or WEBP (Max 10MB)</p>
                            </div>
                        </div>
                        <input type="file" id="guest_inspiration_image" name="inspiration_image" accept="image/*" class="hidden">
                    </div>

                    <!-- DYNAMIC PRESET SECTION (PACKAGE CARDS) -->
                    <div id="guest-section-preset" class="hidden space-y-3">
                        <label class="block text-xs font-bold text-slate-700">Select a Package *</label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @forelse($packages as $package)
                                <label class="guest-package-card p-5 rounded-xl border-2 border-slate-200 cursor-pointer transition-all bg-white hover:border-slate-300 block relative">
                                    <input type="radio" name="package_id" value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'checked' : '' }} class="sr-only">
                                    <span class="text-[10px] font-bold tracking-wider uppercase mb-1 block text-emerald-600">
                                        {{ str_contains(strtolower($package->title), 'wedding') ? 'WEDDINGS' : (str_contains(strtolower($package->title), 'debut') ? 'DEBUTS' : 'CORPORATE') }}
                                    </span>
                                    <div class="font-bold text-slate-900 text-base mb-1">{{ $package->title }}</div>
                                    <div class="text-2xl font-extrabold text-emerald-600 mb-3">₱{{ number_format($package->price, 0) }}</div>
                                    
                                    @if(is_array($package->included_items) && count($package->included_items) > 0)
                                        <ul class="space-y-1 text-xs text-slate-600">
                                            @foreach($package->included_items as $item)
                                                <li class="flex items-center gap-1.5">
                                                    <span class="text-emerald-600 font-bold">✓</span>
                                                    <span>{{ $item }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @elseif($package->description)
                                        <p class="text-xs text-slate-500 leading-relaxed">{{ $package->description }}</p>
                                    @endif
                                </label>
                            @empty
                                <div class="col-span-3 p-4 text-center text-sm text-slate-500 bg-slate-50 rounded-xl border border-slate-200">
                                    No curated packages currently available.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- 3. EVENT SCHEDULE & LOCATION -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800">3. Event Schedule & Location</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Event Type *</label>
                                <select name="event_type" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                                    <option value="">Select Type</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="birthday">Birthday</option>
                                    <option value="corporate">Corporate</option>
                                    <option value="other">Other Event</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Event Date *</label>
                                <input type="date" name="event_date" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Venue Address *</label>
                                <input type="text" name="venue_address" placeholder="Venue location" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Special Requests / Notes</label>
                            <textarea name="special_requests" rows="3" placeholder="Specify color motifs, preferred flower types, or special venue guidelines..." class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-black font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Confirm Guest Booking Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchGuestMode(mode) {
            const cardAi = document.getElementById('guest-card-ai');
            const cardPreset = document.getElementById('guest-card-preset');
            const iconPreset = document.getElementById('preset-icon-box');
            const sectionAi = document.getElementById('guest-section-ai');
            const sectionPreset = document.getElementById('guest-section-preset');

            if (mode === 'ai') {
                cardAi.className = 'relative flex items-start p-4 border-2 border-emerald-600 bg-emerald-50/30 rounded-xl cursor-pointer transition-all';
                cardPreset.className = 'relative flex items-start p-4 border-2 border-slate-200 bg-white rounded-xl cursor-pointer transition-all hover:border-slate-300';
                iconPreset.className = 'w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5 transition-all';
                sectionAi.classList.remove('hidden');
                sectionPreset.classList.add('hidden');
            } else {
                cardPreset.className = 'relative flex items-start p-4 border-2 border-emerald-600 bg-emerald-50/30 rounded-xl cursor-pointer transition-all';
                cardAi.className = 'relative flex items-start p-4 border-2 border-slate-200 bg-white rounded-xl cursor-pointer transition-all hover:border-slate-300';
                iconPreset.className = 'w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 mr-3 mt-0.5 transition-all';
                sectionPreset.classList.remove('hidden');
                sectionAi.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('guestDropzone');
            const fileInput = document.getElementById('guest_inspiration_image');

            if (dropzone && fileInput) {
                dropzone.addEventListener('click', () => fileInput.click());
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            dropzone.innerHTML = `<img src="${ev.target.result}" class="max-h-48 rounded-lg object-contain mx-auto" />`;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('package_id')) {
                switchGuestMode('preset');
                const radioPreset = document.querySelector('input[name="booking_type"][value="preset"]');
                if (radioPreset) radioPreset.checked = true;
            }

            const packageCards = document.querySelectorAll('.guest-package-card');
            packageCards.forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                card.addEventListener('click', function() {
                    packageCards.forEach(c => {
                        c.classList.remove('border-emerald-600', 'ring-1', 'ring-emerald-600');
                        c.classList.add('border-slate-200');
                    });
                    this.classList.remove('border-slate-200');
                    this.classList.add('border-emerald-600', 'ring-1', 'ring-emerald-600');
                });
                if (radio && radio.checked) {
                    card.classList.remove('border-slate-200');
                    card.classList.add('border-emerald-600', 'ring-1', 'ring-emerald-600');
                }
            });
        });
    </script>
</x-app-layout>
