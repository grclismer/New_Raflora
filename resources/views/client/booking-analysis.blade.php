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
                        <span class="text-white font-semibold capitalize">{{ $booking->event_type ?? 'TBD' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/20">
                        <span class="text-white/70">Event Date:</span>
                        <span class="text-white font-semibold">{{ optional($booking->event_date)->format('F j, Y') ?? 'TBD' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/20">
                        <span class="text-white/70">Venue:</span>
                        <span class="text-white font-semibold">{{ $booking->venue ?? 'TBD' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-white/20">
                        <span class="text-white/70">Quotation Expires:</span>
                        <span class="text-white font-semibold">{{ optional($booking->price_valid_until)->format('F j, Y') ?? 'TBD' }}</span>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <p class="text-white/60 text-sm mb-1">Estimated Total Cost</p>
                    <p class="serif text-4xl font-bold text-white">₱{{ number_format($estimatedTotal, 2) }}</p>
                </div>

                <div class="mb-6">
                    <p class="text-white/70 text-sm mb-2">Suggested Procurement Date</p>
                    <p class="text-white/80 text-sm">{{ optional($booking->suggested_procurement_date)->format('F j, Y') ?? 'Not available yet' }}</p>
                </div>

                @if(isset($analysis) && $analysis)
                    <div class="mb-6 p-6 bg-white/5 rounded-lg border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-3">AI Suggested Materials</h3>
                        <div class="space-y-3">
                            @foreach($analysis->suggested_materials as $item)
                                <div class="grid grid-cols-3 gap-4 text-sm text-white/80">
                                    <span>{{ $item['item_name'] }}</span>
                                    <span>{{ ucfirst($item['category']) }}</span>
                                    <span>{{ $item['estimated_quantity'] }} pcs</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(isset($paymentStatus) && $paymentStatus === 'pending')
                    <div class="mb-6 p-5 rounded-lg bg-yellow-900/40 border border-yellow-700 text-yellow-100">
                        <p class="font-semibold">Payment reference submitted.</p>
                        <p class="text-sm">Reference: {{ $paymentReference }} / Method: {{ strtoupper(str_replace('_', ' ', $paymentMethod)) }}. Admin will verify this against the payment record.</p>
                    </div>
                @endif

                @if($booking->status === 'quotation_sent' || $booking->status === 'payment_pending')
                    <div class="mb-6 p-6 rounded-lg bg-white/5 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-3">Submit Payment Reference</h3>
                        <form method="POST" action="{{ route('bookings.payment.reference', ['booking' => $booking->id]) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="payment_type" class="block text-white font-semibold mb-2">Payment Method</label>
                                <select id="payment_type" name="payment_type" class="auth-select w-full rounded-lg border border-white/20 bg-white/5 text-white px-4 py-3">
                                    <option value="gcash">GCash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                            <div>
                                <label for="reference_number" class="block text-white font-semibold mb-2">Reference Number</label>
                                <input type="text" id="reference_number" name="reference_number" placeholder="Enter payment reference" class="auth-input w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white" required>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-700 to-indigo-900 text-white font-semibold py-3 rounded-lg hover:from-indigo-800 hover:to-indigo-950 transition uppercase tracking-wide">
                                Submit Reference
                            </button>
                        </form>
                    </div>
                @endif

                <div class="flex gap-4">
                    @if($booking->status === 'quotation_sent')
                        <form method="POST" action="{{ route('bookings.accept', ['booking' => $booking->id]) }}" class="flex-1">
                            @csrf
                            <button class="w-full bg-gradient-to-r from-purple-700 to-purple-800 hover:from-purple-800 hover:to-purple-900 text-white font-semibold py-3 rounded-lg transition uppercase tracking-wide">
                                Accept Quotation
                            </button>
                        </form>
                    @else
                        <div class="flex-1 bg-white/10 text-center rounded-lg py-3 text-white/70 uppercase tracking-wide">
                            {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                        </div>
                    @endif
                    <a href="{{ route('bookings') }}" class="flex-1 block bg-white/10 hover:bg-white/20 text-white font-semibold py-3 rounded-lg transition uppercase tracking-wide text-center">
                        Back to Bookings
                    </a>
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
