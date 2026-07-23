<x-app-layout title="New Booking">
    <x-client-layout active="bookings">
        <div class="max-w-2xl mx-auto">
            {{-- <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-2">New Booking</h1>
            <p class="text-white/60 text-center text-sm mb-8">Fill out the form below to schedule your event</p> --}}

            <section class="bg-white p-8 max-w-5xl mx-auto rounded-[2rem] shadow-xl border border-gray-200">
                <div class="mb-8 text-center">
                    <h1 class="page-title text-gray-900">Event Foundation</h1>
                    <p class="section-subtitle mt-2 text-gray-600">Start by telling us about the core details of your floral vision.</p>
                </div>

                <div class="grid gap-8 lg:grid-cols-[1.05fr_1fr]">
                    <div class="space-y-6">
                        <div class="rounded-[2rem] overflow-hidden border border-gray-200 bg-slate-50 shadow-sm">
                            <div class="p-6 text-gray-700">
                                <p class="text-sm uppercase tracking-[0.22em] font-semibold text-gray-500">Inspiration Image</p>
                                <p class="mt-2 text-sm text-gray-500">Upload a single photo for AI analysis.</p>
                            </div>
                            <div class="relative h-[420px] bg-white/90 flex items-center justify-center border-t border-gray-200">
                                <div id="imageCard" class="w-full h-full flex items-center justify-center overflow-hidden bg-gray-100 cursor-pointer">
                                    <div id="imagePlaceholder" class="flex flex-col items-center justify-center text-center text-gray-400 px-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        <p class="font-semibold">Upload your inspiration photo</p>
                                        <p class="text-sm text-gray-500 mt-2">Single image only</p>
                                        <button type="button" id="imageUploadButton" class="mt-4 inline-flex items-center rounded-full bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">Choose file</button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 border-t border-gray-200 text-sm text-gray-500">Supported formats: JPG, PNG, HEIC.</div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[2rem] border border-gray-200 bg-slate-50 p-6 shadow-sm">
                            <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <label class="block">
                                        <span class="font-semibold text-gray-700">Event Type</span>
                                        <select name="event_type" id="event_type" class="form-control mt-2 bg-white text-gray-800 border-gray-300">
                                            <option value="">Select Event Type</option>
                                            <option value="wedding">Wedding</option>
                                            <option value="birthday">Birthday</option>
                                            <option value="corporate">Corporate</option>
                                        </select>
                                    </label>

                                    <label class="block">
                                        <span class="font-semibold text-gray-700">Event Date</span>
                                        <input type="date" name="event_date" id="event_date" class="form-control mt-2 bg-white text-gray-800 border-gray-300" />
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <label class="block">
                                        <span class="font-semibold text-gray-700">Event Time</span>
                                        <input type="time" name="event_time" id="event_time" class="form-control mt-2 bg-white text-gray-800 border-gray-300" />
                                    </label>

                                    <label class="block">
                                        <span class="font-semibold text-gray-700">Venue Address</span>
                                        <input type="text" name="venue" id="venue" placeholder="Enter venue address" class="form-control mt-2 bg-white text-gray-800 border-gray-300" required />
                                    </label>
                                </div>

                                <label class="block">
                                    <span class="font-semibold text-gray-700">Special Requests / Notes</span>
                                    <textarea name="special_requests" id="special_requests" rows="5" placeholder="Any specific flowers you love or seasonal preferences?" class="form-control mt-2 bg-white text-gray-800 border-gray-300"></textarea>
                                </label>

                                <input id="inspiration_image" type="file" name="inspiration_image" accept="image/*" class="hidden" />

                                <div class="pt-4 border-t border-gray-200 flex justify-end">
                                    <button type="submit" class="btn-primary px-8 py-3">Confirm Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    (function(){
                        const input = document.getElementById('inspiration_image');
                        const imageUploadButton = document.getElementById('imageUploadButton');
                        const imageCard = document.getElementById('imageCard');

                        imageUploadButton.addEventListener('click', () => input.click());
                        imageCard.addEventListener('click', () => input.click());

                        input.addEventListener('change', (e) => {
                            const file = e.target.files[0];
                            if (!file) return;
                            const reader = new FileReader();
                            reader.onload = (ev) => {
                                imageCard.innerHTML = '<img src="' + ev.target.result + '" alt="Inspiration" class="h-full w-full object-cover" />';
                            };
                            reader.readAsDataURL(file);
                        });
                    })();
                </script>
            </section>
        </div>
    </x-client-layout>
</x-app-layout>
