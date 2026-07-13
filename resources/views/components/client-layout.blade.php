@props(['active' => 'dashboard'])

<div class="min-h-screen flex flex-col bg-cover bg-center" style="background-image: url('{{ asset('assets/images/background.jpg') }}');">
    <div class="absolute inset-0 bg-black/40"></div>

    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-sm shadow-md">
    <!-- Navbar with Envelope Crest Logo -->
    <x-navbar />
    </header>

    <nav id="mobileNav" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm md:hidden">
        <div class="absolute top-4 right-4">
            <button id="mobileMenuClose" class="inline-flex items-center justify-center p-3 rounded-full bg-white shadow" aria-label="Close menu">
                <i class="fa-solid fa-xmark text-gray-900"></i>
            </button>
        </div>
        <div class="h-full flex flex-col justify-center items-center gap-8 text-white text-xl px-6">
            <a href="{{ route('client.dashboard') }}" class="font-semibold">Dashboard</a>
            <a href="{{ route('bookings') }}" class="font-semibold">My Bookings</a>
            <a href="{{ route('booking-history') }}" class="font-semibold">Booking History</a>
            <a href="{{ route('account-settings') }}" class="font-semibold">Account Settings</a>
        </div>
    </nav>

    <div class="flex flex-1 relative z-10">
        <main class="flex-1 p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>

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
</div>
