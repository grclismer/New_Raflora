<x-app-layout>
    <x-navbar />

    <main>
        <!-- Hero Section -->
        <section class="relative bg-cover bg-center h-[640px]" style="background-image: url('{{ asset("assets/images/background.jpg") }}');">
            <div class="absolute inset-0 bg-gradient-to-b from-purple-800/70 via-purple-700/50 to-black/40"></div>
            <div class="max-w-6xl mx-auto relative z-10 h-full flex items-center">
                <div class="px-8 md:px-0 w-full md:w-2/3 text-white">
                    <h1 class="serif text-5xl md:text-6xl leading-tight font-bold">Creating Beautiful &<br> Inspiring <span class="text-4xl md:text-6xl italic">EVENTS</span></h1>
                    @if(auth()->check() || session('dev_user'))
                        <a href="{{ route('bookings.create') }}" class="mt-8 inline-block bg-white text-gray-900 font-semibold px-6 py-3 rounded shadow uppercase">Book now!</a>
                    @else
                        <a href="{{ route('login') }}" class="mt-8 inline-block bg-white text-gray-900 font-semibold px-6 py-3 rounded shadow uppercase">Book now!</a>
                    @endif
                </div>
            </div>
            <svg class="absolute -bottom-1 left-0 w-full" viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg"><path fill="#fff" d="M0,64L60,53.3C120,43,240,21,360,10.7C480,0,600,0,720,10.7C840,21,960,43,1080,58.7C1200,75,1320,85,1380,90.7L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z"></path></svg>
        </section>

        <!-- About Section -->
        <section id="about" class="relative py-20 px-6" style="background-image: url('{{ asset("assets/images/background3.jpg") }}'); background-size: cover; background-position: center;">
            <div class="pt-16 pb-20 relative z-10">
                <div class="grid md:grid-cols-3 gap-8 items-center max-w-5xl mx-auto">
                    <div class="flex justify-center md:justify-end">
                        <img src="{{ asset('assets/images/about_us.jpg') }}" alt="flowers" class="w-56 h-56 rounded-3xl object-cover shadow-md">
                    </div>
                    <div class="md:col-span-2">
                        <h2 class="serif text-3xl md:text-4xl mb-4">ABOUT US</h2>
                        <p class="text-gray-600">We create beautiful floral designs and event setups tailored to each client's vision. Our team handles bookings, material sourcing, and on-site logistics.</p>
                                    <div class="text-center mt-8 relative z-10">
                                        <a href="{{ route('about') }}" class="inline-block bg-white text-gray-900 font-semibold px-8 py-3 rounded shadow uppercase hover:bg-gray-100 transition">View Full About</a>
                                    </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="relative py-20 px-6" style="background-image: url('{{ asset("assets/images/background2.jpg") }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="max-w-6xl mx-auto relative z-10">
                <h3 class="text-3xl serif text-center mb-12 text-white">Raflora Enterprises</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <img src="{{ asset('assets/images/image1.jpg') }}" class="rounded-xl w-full h-48 object-cover" alt="gallery">
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <img src="{{ asset('assets/images/image2.jpg') }}" class="rounded-xl w-full h-48 object-cover" alt="gallery">
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-lg">
                        <img src="{{ asset('assets/images/image3.jpg') }}" class="rounded-xl w-full h-48 object-cover" alt="gallery">
                                    <div class="text-center mt-12 relative z-10">
                                        <a href="{{ route('gallery') }}" class="inline-block bg-white text-gray-900 font-semibold px-8 py-3 rounded shadow uppercase hover:bg-gray-100 transition">View Full Gallery</a>
                                    </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="bg-gray-100 py-12">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-center items-center">
                <div>
                    <i class="fa-solid fa-phone text-3xl text-gray-700"></i>
                    <h4 class="mt-4 font-semibold">CONTACTS</h4>
                    <p class="text-sm text-gray-600">Email: raflora18@gmail.com<br>No.: 0919 008 9881</p>
                </div>
                <div>
                    <i class="fa-solid fa-location-dot text-3xl text-gray-700"></i>
                    <h4 class="mt-4 font-semibold">ADDRESS</h4>
                    <p class="text-sm text-gray-600">Corumi, Masambong, Quezon City, Metro Manila</p>
                </div>
                <div>
                    <i class="fa-regular fa-clock text-3xl text-gray-700"></i>
                    <h4 class="mt-4 font-semibold">Time</h4>
                    <p class="text-sm text-gray-600">Open 24/7</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-purple-700 text-white py-6">
            <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="#" class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center"><i class="fa-brands fa-tiktok"></i></a>
                </div>
                <div class="text-sm">Copyright © 2013 Raflora Enterprises. All Rights Reserved.</div>
            </div>
        </footer>
    </main>

</x-app-layout>
