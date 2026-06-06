<x-app-layout title="Booking Analysis">
    <x-client-layout active="bookings">
        <div class="max-w-2xl mx-auto">
            <div id="loadingState" class="glass-card p-12 text-center">
                <div class="w-16 h-16 rounded-full border-4 border-purple-700 border-t-transparent animate-spin mx-auto mb-6"></div>
                <h2 class="serif text-2xl font-bold text-white mb-2">Analyzing your event requirements using AI...</h2>
                <p class="text-white/60 text-sm">This will take a moment</p>
            </div>

            <div id="quotationState" class="glass-card p-8 hidden">
                <h1 class="serif text-3xl font-bold text-white text-center mb-6">Estimated Quotation</h1>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between py-2 border-b border-white/20">
                        <span class="text-white/70">Event Type:</span>
                        <span class="text-white font-semibold capitalize" id="summaryEventType">Wedding</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/20">
                        <span class="text-white/70">Event Date:</span>
                        <span class="text-white font-semibold" id="summaryEventDate">June 15, 2026</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/20">
                        <span class="text-white/70">Venue:</span>
                        <span class="text-white font-semibold" id="summaryVenue">Sheraton Manila</span>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <p class="text-white/60 text-sm mb-1">Estimated Total Cost</p>
                    <p class="serif text-4xl font-bold text-white">₱25,000</p>
                </div>

                <div class="mb-6">
                    <p class="text-white/70 text-sm mb-2">Suggested Theme</p>
                    <div class="w-full h-32 bg-white/10 rounded-lg flex items-center justify-center border border-white/20">
                        <i class="fa-solid fa-image text-4xl text-white/30"></i>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button class="flex-1 bg-gradient-to-r from-purple-700 to-purple-800 hover:from-purple-800 hover:to-purple-900 text-white font-semibold py-3 rounded-lg transition uppercase tracking-wide">
                        Accept Quotation
                    </button>
                    <button class="flex-1 bg-white/10 hover:bg-white/20 text-white font-semibold py-3 rounded-lg transition uppercase tracking-wide">
                        Modify Request
                    </button>
                </div>
            </div>
        </div>
    </x-client-layout>

    <script>
        setTimeout(() => {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('quotationState').classList.remove('hidden');
        }, 2000);
    </script>
</x-app-layout>
