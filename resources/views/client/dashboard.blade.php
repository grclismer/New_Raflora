<x-app-layout title="Dashboard">
    <x-client-layout active="dashboard">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('bookings') }}" class="glass-card p-8 flex flex-col items-center justify-center text-center hover:bg-white/20 transition group">
                <div class="w-16 h-16 rounded-full bg-purple-700 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <i class="fa-solid fa-plus text-3xl text-white"></i>
                </div>
                <h2 class="serif text-2xl font-bold text-white mb-2">New Booking</h2>
                <p class="text-white/60 text-sm">Start planning your next event with us</p>
            </a>

            <div class="glass-card p-6">
                <h2 class="serif text-xl font-bold text-white mb-4">Recent Activity</h2>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                        <div class="flex-1">
                            <p class="text-white text-sm font-medium">Wedding Anniversary - Confirmed</p>
                            <p class="text-white/50 text-xs">May 20, 2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                        <div class="flex-1">
                            <p class="text-white text-sm font-medium">Birthday Party - Pending</p>
                            <p class="text-white/50 text-xs">May 18, 2026</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 md:col-span-2">
                <h2 class="serif text-xl font-bold text-white mb-4">Account Summary</h2>
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=8b5cf6&color=fff&size=128" alt="Profile" class="w-16 h-16 rounded-full">
                    <div>
                        <p class="text-white font-semibold text-lg">John Doe</p>
                        <p class="text-white/60 text-sm">john.doe@example.com</p>
                        <p class="text-white/60 text-sm">0919 008 9881</p>
                    </div>
                </div>
            </div>
        </div>
    </x-client-layout>
</x-app-layout>
