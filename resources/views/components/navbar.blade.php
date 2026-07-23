@props(['active' => null])

<header class="sticky top-0 z-40 bg-white shadow-md relative">
    <div class="max-w-6xl mx-auto px-4 md:px-16 py-6 flex items-center justify-between">
        <!-- Left Navigation -->
        <div class="hidden md:flex items-center gap-8 text-sm">
            <a href="{{ route('home') }}" class="hover:underline font-semibold">HOME</a>
            @if(Route::currentRouteName() === 'home')
                <!-- Scroll links on homepage -->
                <a href="#gallery" class="hover:underline font-semibold">GALLERY</a>
            @else
                <!-- Direct route links on other pages -->
                <a href="{{ route('gallery') }}" class="hover:underline font-semibold">GALLERY</a>
            @endif
        </div>

        <!-- Center Logo - Half extending below navbar -->
        <div class="absolute left-1/2 -translate-x-1/2 top-0 mt-2 z-50">
        <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center shadow-xl border-4 border-white">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="logo" class="rounded-full object-cover w-28 h-28">
        </div>
    </div>

        <!-- Right Navigation -->
        <div class="hidden md:flex items-center gap-8 text-sm">
            @if(Route::currentRouteName() === 'home')
                <!-- Scroll links on homepage -->
                <a href="#about" class="hover:underline font-semibold">ABOUT</a>
            @else
                <!-- Direct route links on other pages -->
                <a href="{{ route('about') }}" class="hover:underline font-semibold">ABOUT</a>
            @endif
            <a href="{{ route('booking.start') }}" class="hover:underline font-semibold">BOOKING</a>
            @if(auth()->check() || session('dev_user'))
                <x-avatar-dropdown />
            @else
                <a href="{{ route('login') }}" class="hover:underline font-semibold">LOG IN</a>
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden inline-flex items-center justify-center p-3 rounded-full bg-white shadow-lg" aria-label="Toggle menu">
            <i class="fa-solid fa-bars text-gray-900"></i>
        </button>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobileNav" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm">
        <div class="absolute top-4 right-4">
            <button id="mobileMenuClose" class="inline-flex items-center justify-center p-3 rounded-full bg-white shadow-lg" aria-label="Close menu">
                <i class="fa-solid fa-xmark text-gray-900"></i>
            </button>
        </div>
        <div class="h-full flex flex-col justify-center items-center gap-8 text-white text-xl px-6">
            <a href="{{ route('home') }}" class="font-semibold">HOME</a>
            @if(Route::currentRouteName() === 'home')
                <a href="#gallery" class="font-semibold">GALLERY</a>
            @else
                <a href="{{ route('gallery') }}" class="font-semibold">GALLERY</a>
            @endif
            <a href="{{ route('booking.start') }}" class="font-semibold">BOOKING</a>
            @if(auth()->check() || session('dev_user'))
                <a href="{{ route('bookings') }}" class="font-semibold">MY BOOKINGS</a>
                <a href="{{ route('account-settings') }}" class="font-semibold">ACCOUNT SETTINGS</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="font-semibold text-red-400 hover:text-red-500">LOG OUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="font-semibold">LOG IN</a>
            @endif
        </div>
    </div>
</header>

<script>
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const mobileNav = document.getElementById('mobileNav');

    if (mobileMenuButton && mobileMenuClose && mobileNav) {
        const toggleMobileNav = () => mobileNav.classList.toggle('hidden');
        mobileMenuButton.addEventListener('click', toggleMobileNav);
        mobileMenuClose.addEventListener('click', toggleMobileNav);
        mobileNav.addEventListener('click', (event) => {
            if (event.target === mobileNav) {
                toggleMobileNav();
            }
        });
    }
</script>
