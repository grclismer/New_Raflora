<x-app-layout title="New Booking">
    <x-client-layout active="bookings">
        <div class="max-w-2xl mx-auto">
            <h1 class="serif text-3xl md:text-4xl font-bold text-white text-center mb-2">New Booking</h1>
            <p class="text-white/60 text-center text-sm mb-8">Fill out the form below to schedule your event</p>

            <section class="section-card p-10 max-w-3xl mx-auto">
                <div class="mb-10 text-center">
                    <h1 class="page-title">New Booking</h1>
                    <p class="section-subtitle mt-4">Fill out your event details and upload an inspiration image for a smarter quotation.</p>
                </div>

                <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="block">
                            <span class="text-white font-semibold">Event Type</span>
                            <select name="event_type" id="event_type" class="form-control mt-2 text-white">
                                <option value="">Select Event Type</option>
                                <option value="wedding">Wedding</option>
                                <option value="birthday">Birthday</option>
                                <option value="corporate">Corporate</option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-white font-semibold">Event Date</span>
                            <input type="date" name="event_date" id="event_date" class="form-control mt-2 text-white" />
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="block">
                            <span class="text-white font-semibold">Event Time</span>
                            <input type="time" name="event_time" id="event_time" class="form-control mt-2 text-white" />
                        </label>

                        <label class="block">
                            <span class="text-white font-semibold">Event Venue</span>
                            <input type="text" name="venue" id="venue" placeholder="Enter venue address" class="form-control mt-2 text-white" required />
                        </label>
                    </div>

                    <label class="block">
                        <span class="text-white font-semibold">Special Requests</span>
                        <textarea name="special_requests" id="special_requests" rows="4" placeholder="Any special requirements or notes..." class="form-control mt-2 text-white"></textarea>
                    </label>

                    <label class="block">
                        <span class="text-white font-semibold">Inspiration Image</span>
                        <input type="file" name="inspiration_image" id="inspiration_image" accept="image/*" class="form-control mt-2 text-white" />
                    </label>

                    <button type="submit" class="btn-primary w-full">Confirm Appointment</button>
                </form>
            </section>
        </div>
    </x-client-layout>
</x-app-layout>
