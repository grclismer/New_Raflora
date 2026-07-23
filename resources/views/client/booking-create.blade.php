<x-app-layout title="New Booking">
    <x-client-layout active="bookings">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 sm:p-10 rounded-2xl shadow-xl border border-slate-100">
                <!-- Header -->
                <span class="inline-block bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full w-max mb-2">Authenticated Client Portal</span>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Create Event Booking</h1>
                <p class="text-sm text-slate-500 mt-1 mb-8">Choose how you would like to customize your floral arrangement request.</p>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- 1. SELECT BOOKING TYPE -->
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3">1. Select Booking Type</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- AI Card -->
                            <label id="card-ai" onclick="switchMode('ai')" class="relative flex items-start p-4 border-2 border-emerald-600 bg-white rounded-xl cursor-pointer transition-all shadow-sm ring-1 ring-emerald-600">
                                <input type="radio" name="booking_type" value="custom_ai" checked class="sr-only">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 mr-3 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <span class="font-bold text-slate-900 text-sm">Smart AI Custom Design</span>
                                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded ml-2 uppercase">POPULAR</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-snug">Upload your inspiration image. Our Gemini AI will analyze flowers and compute instant pricing.</p>
                                </div>
                            </label>

                            <!-- Preset Card -->
                            <label id="card-preset" onclick="switchMode('preset')" class="relative flex items-start p-4 border-2 border-slate-200 bg-white rounded-xl cursor-pointer transition-all hover:border-slate-300">
                                <input type="radio" name="booking_type" value="preset" class="sr-only">
                                <div id="client-preset-icon-box" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">Pre-Set Curated Package</div>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-snug">Select from our ready-made floral packages with fixed pricing set by our master florists.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- DYNAMIC AI SECTION -->
                    <div id="section-ai" class="p-6 bg-slate-50/60 rounded-xl border border-dashed border-emerald-300">
                        <label class="block text-xs font-bold text-slate-700 mb-3">Upload Inspiration Image *</label>
                        <div id="clientDropzone" class="bg-white border border-dashed border-emerald-400 rounded-xl p-8 text-center cursor-pointer hover:bg-emerald-50/20 transition flex flex-col items-center justify-center">
                            <div id="clientImagePlaceholder" class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-800">Upload your event photo or bouquet reference</p>
                                <p class="text-xs text-slate-400 mt-1">PNG, JPG or WEBP (Max 10MB)</p>
                            </div>
                        </div>
                        <input type="file" id="client_inspiration_image" name="inspiration_image" accept="image/*" class="hidden">
                    </div>

                    <!-- DYNAMIC PRESET PACKAGE CARDS GRID -->
                    <div id="section-preset" class="hidden space-y-3">
                        <label class="block text-xs font-bold text-slate-700">Select a Package *</label>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @forelse($packages as $package)
                                @php
                                    $titleLower = strtolower($package->title);
                                    $tagColor = str_contains($titleLower, 'wedding') ? 'text-emerald-600' : (str_contains($titleLower, 'debut') ? 'text-purple-600' : 'text-blue-600');
                                    $tagName = str_contains($titleLower, 'wedding') ? 'WEDDINGS' : (str_contains($titleLower, 'debut') ? 'DEBUTS' : 'CORPORATE');
                                @endphp
                                <label class="client-package-card p-5 rounded-xl border-2 border-slate-200 cursor-pointer transition-all bg-white hover:border-slate-300 block relative">
                                    <input type="radio" name="package_id" value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'checked' : '' }} class="sr-only">
                                    <span class="text-[10px] font-bold tracking-wider uppercase mb-1 block {{ $tagColor }}">
                                        {{ $tagName }}
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

                    <!-- 2. EVENT DETAILS -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800">2. Event Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Event Type *</label>
                                <select name="event_type" id="event_type" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                                    <option value="">Select Type</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="birthday">Birthday</option>
                                    <option value="corporate">Corporate</option>
                                    <option value="other">Other Event</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Event Date *</label>
                                <input type="date" name="event_date" id="event_date" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Event Time</label>
                                <input type="time" name="event_time" id="event_time" class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Venue Address *</label>
                            <input type="text" name="venue" id="venue" placeholder="e.g. Grand Ballroom, Shangri-La Fort, BGC" required class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Special Requests / Notes</label>
                            <textarea name="special_requests" id="special_requests" rows="3" placeholder="Specify color motifs, preferred flower types, or special venue guidelines..." class="w-full p-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-slate-800"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-black font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Submit Booking Request
                    </button>
                </form>
            </div>
        </div>
    </x-client-layout>
</x-app-layout>

<script>
    function switchMode(mode) {
        const cardAi = document.getElementById('card-ai');
        const cardPreset = document.getElementById('card-preset');
        const iconPreset = document.getElementById('client-preset-icon-box');
        const sectionAi = document.getElementById('section-ai');
        const sectionPreset = document.getElementById('section-preset');

        if (mode === 'ai') {
            cardAi.className = 'relative flex items-start p-4 border-2 border-emerald-600 bg-white rounded-xl cursor-pointer transition-all shadow-sm ring-1 ring-emerald-600';
            cardPreset.className = 'relative flex items-start p-4 border-2 border-slate-200 bg-white rounded-xl cursor-pointer transition-all hover:border-slate-300';
            iconPreset.className = 'w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 mr-3 mt-0.5 transition-all';
            sectionAi.classList.remove('hidden');
            sectionPreset.classList.add('hidden');
        } else {
            cardPreset.className = 'relative flex items-start p-4 border-2 border-emerald-600 bg-white rounded-xl cursor-pointer transition-all shadow-sm ring-1 ring-emerald-600';
            cardAi.className = 'relative flex items-start p-4 border-2 border-slate-200 bg-white rounded-xl cursor-pointer transition-all hover:border-slate-300';
            iconPreset.className = 'w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 mr-3 mt-0.5 transition-all';
            sectionPreset.classList.remove('hidden');
            sectionAi.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('clientDropzone');
        const fileInput = document.getElementById('client_inspiration_image');

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
            switchMode('preset');
            const radioPreset = document.querySelector('input[name="booking_type"][value="preset"]');
            if (radioPreset) radioPreset.checked = true;
        }

        const packageCards = document.querySelectorAll('.client-package-card');
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
