<x-app-layout>
    <x-navbar />
    <main class="relative">
        <div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/images/background.jpg') }}');">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-12 py-20">
                <!-- Page Header -->
                <div class="text-center mb-16">
                    <h1 class="serif text-5xl md:text-6xl text-white mb-4">OUR GALLERY</h1>
                    <p class="text-lg text-gray-200">Explore our collection of beautifully crafted floral designs and event setups from past celebrations.</p>
                </div>

                <!-- Gallery Grid - Expanded -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Gallery Item 1 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('assets/images/image1.jpg') }}" class="w-full h-64 object-cover" alt="Wedding Floral Design">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-xl font-semibold opacity-0 group-hover:opacity-100 transition">Wedding Floral</span>
                        </div>
                    </div>

                    <!-- Gallery Item 2 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('assets/images/image2.jpg') }}" class="w-full h-64 object-cover" alt="Corporate Event">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-xl font-semibold opacity-0 group-hover:opacity-100 transition">Corporate Event</span>
                        </div>
                    </div>

                    <!-- Gallery Item 3 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('assets/images/image3.jpg') }}" class="w-full h-64 object-cover" alt="Birthday Celebration">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-xl font-semibold opacity-0 group-hover:opacity-100 transition">Birthday Setup</span>
                        </div>
                    </div>

                    <!-- Gallery Item 4 (Duplicate for demo) -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('assets/images/image1.jpg') }}" class="w-full h-64 object-cover" alt="Reception Setup">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-xl font-semibold opacity-0 group-hover:opacity-100 transition">Reception Setup</span>
                        </div>
                    </div>

                    <!-- Gallery Item 5 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('assets/images/image2.jpg') }}" class="w-full h-64 object-cover" alt="Ceremony Decor">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-xl font-semibold opacity-0 group-hover:opacity-100 transition">Ceremony Decor</span>
                        </div>
                    </div>

                    <!-- Gallery Item 6 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('assets/images/image3.jpg') }}" class="w-full h-64 object-cover" alt="Table Arrangements">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-xl font-semibold opacity-0 group-hover:opacity-100 transition">Table Arrangements</span>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="text-center mt-16">
                    <p class="text-gray-200 text-lg mb-6">Interested in creating your perfect event?</p>
                    @if(auth()->check() || session('dev_user'))
                        <a href="{{ route('bookings.create') }}" class="inline-block bg-white text-gray-900 font-semibold px-10 py-4 rounded shadow-lg uppercase hover:bg-gray-100 transition">Create Booking</a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block bg-white text-gray-900 font-semibold px-10 py-4 rounded shadow-lg uppercase hover:bg-gray-100 transition">Get Started</a>
                    @endif
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
