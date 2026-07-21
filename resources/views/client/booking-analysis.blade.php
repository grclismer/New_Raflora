<x-app-layout title="Booking Analysis">
    <x-client-layout active="bookings">
        <div class="max-w-2xl mx-auto">
            <div id="loadingState" class="section-card p-12 text-center">
                <div class="w-16 h-16 rounded-full border-4 border-purple-700 border-t-transparent animate-spin mx-auto mb-6"></div>
                <h2 class="page-title text-3xl sm:text-4xl mb-4">Analyzing your event requirements with AI...</h2>
                <p class="section-subtitle">Hang tight — we are preparing your personalized quotation.</p>
            </div>

            <div id="quotationState" class="section-card p-10 hidden">
                <div class="mb-8 text-center">
                    <h1 class="page-title">Estimated Quotation</h1>
                    <p class="section-subtitle mt-3">Review the suggested materials, cost estimate, and payment options below.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10">
                        <p class="text-white/70 mb-3">Event Type</p>
                        <p class="text-white font-semibold capitalize">{{ $booking->event_type ?? 'TBD' }}</p>
                    </div>
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10">
                        <p class="text-white/70 mb-3">Event Date</p>
                        <p class="text-white font-semibold">{{ optional($booking->event_date)->format('F j, Y') ?? 'TBD' }}</p>
                    </div>
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10">
                        <p class="text-white/70 mb-3">Event Time</p>
                        <p class="text-white font-semibold">{{ $booking->event_time ? date('g:i A', strtotime($booking->event_time)) : 'TBD' }}</p>
                    </div>
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10">
                        <p class="text-white/70 mb-3">Quotation Expires</p>
                        <p class="text-white font-semibold">{{ optional($booking->price_valid_until)->format('F j, Y') ?? 'TBD' }}</p>
                    </div>
                </div>

                <div class="text-center mb-10">
                    <p class="text-white/70 uppercase tracking-[0.25em] text-xs mb-2">Estimated Total Cost</p>
                    <p class="serif text-5xl font-bold text-white">₱{{ number_format($totalCost ?? 0, 2) }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10">
                        <p class="text-white/70 mb-3">Venue</p>
                        <p class="text-white font-semibold">{{ $booking->venue ?? 'TBD' }}</p>
                    </div>
                    <div class="bg-white/10 rounded-3xl p-6 border border-white/10">
                        <p class="text-white/70 mb-3">Suggested Procurement Date</p>
                        <p class="text-white font-semibold">{{ optional($booking->suggested_procurement_date)->format('F j, Y') ?? 'Not available yet' }}</p>
                    </div>
                </div>

                @php
                    $analysisMaterials = $analysisMaterials ?? [];
                @endphp

                @if(isset($items) && $items && $items->count() > 0)
                    <div class="mb-6 p-6 bg-white/5 rounded-lg border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-3">AI Suggested Materials</h3>
                        <div class="max-h-[350px] overflow-y-auto pr-2 space-y-3 custom-scrollbar" style="max-height: 350px; overflow-y: auto; padding-right: 8px;">
                            @foreach($items as $item)
                                <div class="grid grid-cols-4 gap-4 text-sm text-white/80">
                                    <span class="col-span-2">{{ $item->name }}</span>
                                    <span>{{ number_format($item->pivot->quantity, 0) }} {{ $item->unit ?? 'pcs' }}</span>
                                    <span>₱{{ number_format($item->pivot->quoted_unit_price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(is_array($analysisMaterials) && count($analysisMaterials) > 0)
                    <div class="mb-6 p-6 bg-white/5 rounded-lg border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-3">AI Suggested Materials</h3>
                        <div class="max-h-[300px] overflow-y-auto pr-2 space-y-3 custom-scrollbar" style="max-height: 300px; overflow-y: auto; padding-right: 8px;">
                            @foreach($analysisMaterials as $item)
                                <div class="grid grid-cols-4 gap-4 text-sm text-white/80">
                                    <span class="col-span-2">{{ $item['item_name'] ?? 'Unknown item' }}</span>
                                    <span>{{ number_format($item['estimated_quantity'] ?? 1, 0) }} {{ $item['unit_type'] ?? 'pcs' }}</span>
                                    <span>₱{{ number_format($item['estimated_unit_cost_php'] ?? 0, 2) }}</span>
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
                    <div class="mb-6 rounded-3xl border border-white/10 bg-white/10 p-6">
                        <h3 class="text-lg font-semibold text-white mb-3">Submit Payment Reference</h3>
                        <form method="POST" action="{{ route('bookings.payment.reference', ['booking' => $booking->id]) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="payment_type" class="block text-white font-semibold mb-2">Payment Method</label>
                                <select id="payment_type" name="payment_type" class="form-control mt-2 text-white">
                                    <option value="gcash">GCash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                            <div>
                                <label for="reference_number" class="block text-white font-semibold mb-2">Reference Number</label>
                                <input type="text" id="reference_number" name="reference_number" placeholder="Enter payment reference" class="form-control mt-2 text-white" required>
                            </div>
                            <button type="submit" class="btn-primary w-full">Submit Reference</button>
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
