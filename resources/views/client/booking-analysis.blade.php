<x-app-layout title="Booking Analysis">
    <x-client-layout active="bookings">
        <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <div id="loadingState" class="section-card p-12 text-center">
                <div class="w-16 h-16 rounded-full border-4 border-purple-700 border-t-transparent animate-spin mx-auto mb-6"></div>
                <h2 class="page-title text-3xl sm:text-4xl mb-4">Analyzing your event requirements...</h2>
                <p class="section-subtitle">Preparing your quotation. This may take a moment.</p>
            </div>

            <div id="quotationState" class="hidden">
                <!-- <div class="mb-10 text-center">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-500 mb-3">Quotation overview</p>
                    <h1 class="text-4xl font-semibold text-slate-900">Estimated Quotation</h1>
                    <p class="mt-3 max-w-2xl mx-auto text-sm text-slate-600">Review the suggested materials, cost estimate, and payment options in a clean split layout.</p>
                </div> -->

                <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr] md:grid-cols-2 mb-8 max-w-[85rem] mx-auto items-start">
                    <!-- Left Column -->
                    <div class="rounded-3xl bg-white shadow-sm p-6 sm:p-8 flex flex-col border border-slate-100">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <span class="inline-block bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-md mb-3">Primary Concept</span>
                                <h2 class="text-3xl sm:text-4xl font-bold text-slate-800 tracking-tight mb-2">{{ ucfirst($booking->event_type ?? 'Event') }} Proposal</h2>
                                <p class="text-slate-500 text-sm max-w-md">A curated concept based on your uploaded inspiration image and event details.</p>
                            </div>
                            <div class="flex gap-2 hidden sm:flex">
                                <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                                <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="rounded-2xl overflow-hidden bg-slate-100 w-full" style="max-height: 500px !important; height: 400px !important;">
                            @if($booking->inspiration_image)
                                <img src="{{ asset('storage/' . $booking->inspiration_image) }}" alt="Inspiration Image" class="w-full h-full object-cover object-center" />
                            @else
                                <div class="flex h-full items-center justify-center text-slate-400 text-sm">
                                    No inspiration image uploaded.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column (Container for multiple cards) -->
                    <div class="flex flex-col gap-6">
                        <!-- Pricing Summary Card -->
                        <div class="rounded-3xl bg-white shadow-sm flex flex-col overflow-hidden border border-slate-100">
                            <!-- Header -->
                            <div class="p-6 sm:p-8 border-b border-slate-100">
                                <h2 class="text-2xl font-bold text-slate-800">Pricing Summary</h2>
                                <p class="text-xs font-semibold text-slate-400 tracking-widest uppercase mt-1">{{ strtoupper($booking->event_type ?? 'Event') }} PACKAGE</p>
                            </div>

                            <!-- Deliverables -->
                            <div class="p-6 sm:p-8 flex-grow space-y-6">
                                @php
                                    $materials = (isset($items) && $items && $items->count() > 0)
                                        ? $items->map(fn($item) => [
                                            'name' => $item->name,
                                            'quantity' => number_format($item->pivot->quantity, 0) . ' ' . ($item->unit ?? 'pcs'),
                                            'cost' => '₱' . number_format($item->pivot->quoted_unit_price, 2),
                                            'subtotal' => '₱' . number_format($item->pivot->quantity * $item->pivot->quoted_unit_price, 2),
                                        ])->toArray()
                                        : (is_array($analysisMaterials) ? array_map(fn($item) => [
                                            'name' => $item['item_name'] ?? 'Unknown item',
                                            'quantity' => number_format($item['estimated_quantity'] ?? 1, 0) . ' ' . ($item['unit_type'] ?? 'pcs'),
                                            'cost' => '₱' . number_format($item['estimated_unit_cost_php'] ?? 0, 2),
                                            'subtotal' => '₱' . number_format(($item['estimated_quantity'] ?? 1) * ($item['estimated_unit_cost_php'] ?? 0), 2),
                                        ], $analysisMaterials) : []);
                                @endphp

                                @foreach(array_slice($materials, 0, 8) as $material)
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold text-slate-800">{{ $material['name'] }}</h4>
                                            <p class="text-sm text-slate-500">{{ $material['quantity'] }} @ {{ $material['cost'] }} / each</p>
                                        </div>
                                        <div class="font-medium text-slate-700">
                                            {{ $material['subtotal'] }}
                                        </div>
                                    </div>
                                @endforeach
                                @if(count($materials) > 8)
                                    <div class="text-sm text-slate-400 italic">
                                        + {{ count($materials) - 8 }} more deliverable{{ count($materials) - 8 === 1 ? '' : 's' }}
                                    </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="bg-slate-100 p-6 sm:p-8 rounded-b-3xl">
                                <div class="flex justify-between items-center mb-6">
                                    <span class="text-lg font-bold text-slate-800">Total Quotation</span>
                                    <span class="text-2xl font-bold text-purple-700">₱{{ number_format($totalCost ?? 0, 2) }}</span>
                                </div>
                                
                                <div class="flex gap-3">
                                    @if($booking->status === 'quotation_sent')
                                        <form method="POST" action="{{ route('bookings.accept', ['booking' => $booking->id]) }}" class="flex-1">
                                            @csrf
                                            <button class="w-full bg-purple-700 hover:bg-purple-800 text-white font-medium py-3 rounded-xl flex justify-center items-center gap-2 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                                Approve
                                            </button>
                                        </form>
                                    @elseif($booking->status === 'pending')
                                        <div class="flex-1 rounded-xl bg-amber-100/60 text-amber-700 font-medium py-3 text-center flex justify-center items-center uppercase text-sm">
                                            Pending Admin Review
                                        </div>
                                    @else
                                        <div class="flex-1 rounded-xl bg-purple-700/10 text-purple-700 font-medium py-3 text-center flex justify-center items-center uppercase text-sm">
                                            {{ str_replace('_', ' ', $booking->status) }}
                                        </div>
                                    @endif

                                    <a href="{{ route('bookings') }}" class="flex-1 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium py-3 rounded-xl flex justify-center items-center gap-2 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                        Changes
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Sections (Stacked below Pricing Summary) -->
                        @if(isset($paymentStatus) && $paymentStatus === 'pending')
                            <div class="rounded-3xl border border-amber-300/30 bg-amber-100/60 p-6 sm:p-8 text-amber-950 shadow-sm">
                                <p class="font-semibold text-lg mb-1">Payment reference submitted.</p>
                                <p class="text-sm">Reference: {{ $paymentReference }} <br/> Method: {{ strtoupper(str_replace('_', ' ', $paymentMethod)) }} <br/><br/> Admin will verify this against the payment record.</p>
                            </div>
                        @endif

                        @if($booking->status === 'quotation_sent' || $booking->status === 'payment_pending')
                            <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
                                <h3 class="text-xl font-bold text-slate-800 mb-4">Submit Payment Reference</h3>
                                <form method="POST" action="{{ route('bookings.payment.reference', ['booking' => $booking->id]) }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="payment_type" class="block text-slate-700 font-semibold mb-2">Payment Method</label>
                                        <select id="payment_type" name="payment_type" class="w-full rounded-xl border-slate-200 focus:border-purple-500 focus:ring-purple-500 text-slate-900 bg-white">
                                            <option value="gcash">GCash</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="reference_number" class="block text-slate-700 font-semibold mb-2">Reference Number</label>
                                        <input type="text" id="reference_number" name="reference_number" placeholder="Enter payment reference" class="w-full rounded-xl border-slate-200 focus:border-purple-500 focus:ring-purple-500 text-slate-900 bg-white" required>
                                    </div>
                                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-medium py-3 px-6 rounded-xl transition">Submit Reference</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-client-layout>

    <script>
        const loadingState = document.getElementById('loadingState');
        const quotationState = document.getElementById('quotationState');

        if (loadingState && quotationState) {
            setTimeout(() => {
                loadingState.classList.add('hidden');
                quotationState.classList.remove('hidden');
            }, 2000);
        } else if (quotationState) {
            quotationState.classList.remove('hidden');
        }
    </script>
</x-app-layout>
