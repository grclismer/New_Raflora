<x-app-layout title="New Booking">
    <x-client-layout active="bookings">
        <div class="max-w-2xl mx-auto">
            <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-2">New Booking</h1>
            <p class="text-white/60 text-center text-sm mb-8">Fill out the form below to schedule your event</p>

            <div class="glass-card p-8">
                <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="event_type" class="block text-white font-semibold mb-2">Event Type</label>
                        <select name="event_type" id="event_type" class="auth-select px-2 py-2 text-white cursor-pointer pr-10 w-full rounded-lg border border-white/20 bg-white/5">
                            <option value="" class="text-gray-900">Select Event Type</option>
                            <option value="wedding" class="text-gray-900">Wedding</option>
                            <option value="birthday" class="text-gray-900">Birthday</option>
                            <option value="corporate" class="text-gray-900">Corporate</option>
                        </select>
                    </div>

                    <div>
                        <label for="event_date" class="block text-white font-semibold mb-2">Event Date</label>
                        <input type="date" name="event_date" id="event_date" class="auth-input px-2 py-2 text-white cursor-pointer w-full rounded-lg border border-white/20 bg-white/5">
                    </div>

                    <div>
                        <label for="venue" class="block text-white font-semibold mb-2">Event Venue</label>
                        <div class="flex items-center gap-3 border-b border-white/30 pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <input type="text" name="venue" id="venue" placeholder="Enter venue address" class="auth-input flex-1 w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white" required>
                        </div>
                    </div>

                    <div>
                        <label for="special_requests" class="block text-white font-semibold mb-2">Special Requests</label>
                        <textarea name="special_requests" id="special_requests" rows="4" placeholder="Any special requirements or notes..." class="auth-textarea w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white resize-none"></textarea>
                    </div>

                    <div>
                        <label for="inspiration_image" class="block text-white font-semibold mb-2">Inspiration Image</label>
                        <input type="file" name="inspiration_image" id="inspiration_image" accept="image/*" class="auth-input w-full cursor-pointer text-white">
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-purple-700 to-purple-800 text-white font-semibold py-3 rounded-lg hover:from-purple-800 hover:to-purple-900 transition uppercase tracking-wide">
                        Confirm Appointment
                    </button>
                </form>
            </div>
        </div>
    </x-client-layout>
</x-app-layout>
