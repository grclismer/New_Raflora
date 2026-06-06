<div class="min-h-screen flex bg-cover bg-center" style="background-image: url('{{ asset('assets/images/login_form.jpg') }}');">
    <div class="absolute inset-0 bg-black/50"></div>

    <aside class="w-1/5 min-w-64 relative z-10 flex flex-col items-center justify-center p-8">
        <a href="{{ route('home') }}" class="mb-8">
            <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center border-4 border-white shadow-lg">
                <img src="{{ asset('assets/images/logo.jpg') }}" alt="Raflora Enterprises" class="rounded-full object-cover w-28 h-28">
            </div>
        </a>
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-white/70 hover:text-white transition text-sm font-semibold">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Home
        </a>
    </aside>

    <main class="flex-1 relative z-10 flex items-center justify-center p-8">
        {{ $slot }}
    </main>
</div>
