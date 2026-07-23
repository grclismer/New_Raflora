<x-app-layout>
    <x-navbar />
    <main class="relative">
        <div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/images/background.jpg') }}');">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-12 py-20">
                <!-- Page Header -->
                <div class="text-center mb-16">
                    <h1 class="serif text-5xl md:text-6xl text-white mb-4">ABOUT RAFLORA</h1>
                    <p class="text-lg text-gray-200">Bringing life and color to every celebration since 2015</p>
                </div>

                <!-- About Section 1 -->
                <div class="bg-white/95 rounded-2xl p-10 md:p-14 mb-10 shadow-xl">
                    <h2 class="serif text-3xl md:text-4xl text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-700 text-lg leading-relaxed mb-4">
                        Raflora Enterprises was founded with a simple vision: to transform ordinary events into extraordinary celebrations through the beauty and elegance of floral design. What started as a small family venture has grown into a trusted name in the Philippine event industry.
                    </p>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Today, we pride ourselves on our commitment to quality, creativity, and customer satisfaction. Every event we handle is a canvas for our passion, and every client is a valued part of our growing family.
                    </p>
                </div>

                <!-- About Section 2 -->
                <div class="bg-white/95 rounded-2xl p-10 md:p-14 mb-10 shadow-xl">
                    <h2 class="serif text-3xl md:text-4xl text-gray-900 mb-6">What We Do</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-400 to-rose-400 rounded-full mb-4">
                                <i class="fa-solid fa-flower text-white text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Floral Design</h3>
                            <p class="text-gray-600">Custom flower arrangements and installations tailored to your event theme</p>
                        </div>
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-full mb-4">
                                <i class="fa-solid fa-boxes text-white text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Event Setup</h3>
                            <p class="text-gray-600">Complete on-site decoration and logistics management</p>
                        </div>
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-400 rounded-full mb-4">
                                <i class="fa-solid fa-handshake text-white text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Consultation</h3>
                            <p class="text-gray-600">Expert guidance from booking to execution</p>
                        </div>
                    </div>
                </div>

                <!-- About Section 3 -->
                <div class="bg-white/95 rounded-2xl p-10 md:p-14 mb-10 shadow-xl">
                    <h2 class="serif text-3xl md:text-4xl text-gray-900 mb-6">Our Specialties</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start gap-4">
                            <i class="fa-solid fa-heart text-rose-400 text-2xl mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Weddings</h3>
                                <p class="text-gray-600">From intimate ceremonies to grand receptions, we create the perfect floral backdrop for your special day</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="fa-solid fa-building text-blue-400 text-2xl mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Corporate Events</h3>
                                <p class="text-gray-600">Professional and elegant setups for conferences, galas, and business celebrations</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="fa-solid fa-cake-candles text-amber-400 text-2xl mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Birthdays & Debuts</h3>
                                <p class="text-gray-600">Vibrant and personalized designs to celebrate life's important milestones</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="fa-solid fa-utensils text-orange-400 text-2xl mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Other Occasions</h3>
                                <p class="text-gray-600">Anniversaries, reunions, engagements, and more - no event too unique</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About Section 4 -->
                <div class="bg-white/95 rounded-2xl p-10 md:p-14 shadow-xl">
                    <h2 class="serif text-3xl md:text-4xl text-gray-900 mb-6">Why Choose Us?</h2>
                    <ul class="space-y-4 text-gray-700 text-lg">
                        <li class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-rose-400 rounded-full"><i class="fa-solid fa-check text-white text-sm"></i></span>
                            <span>Over 10 years of experience in the floral and event industry</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-rose-400 rounded-full"><i class="fa-solid fa-check text-white text-sm"></i></span>
                            <span>Professional team trained in design, logistics, and customer service</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-rose-400 rounded-full"><i class="fa-solid fa-check text-white text-sm"></i></span>
                            <span>Quality materials and fresh flowers sourced from trusted suppliers</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-rose-400 rounded-full"><i class="fa-solid fa-check text-white text-sm"></i></span>
                            <span>Flexible booking options and competitive pricing</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-rose-400 rounded-full"><i class="fa-solid fa-check text-white text-sm"></i></span>
                            <span>100% satisfaction guarantee for every event</span>
                        </li>
                    </ul>
                </div>

                <!-- Call to Action -->
                <div class="text-center mt-16">
                    <p class="text-white text-lg mb-6 text-shadow">Ready to make your event unforgettable?</p>
                    <a href="{{ route('booking.start') }}" class="inline-block bg-white text-gray-900 font-semibold px-10 py-4 rounded shadow-lg uppercase hover:bg-gray-100 transition">Book Now</a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
