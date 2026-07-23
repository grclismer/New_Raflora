<x-app-layout title="Guest Booking Analysis">
    <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div id="loadingState" class="section-card p-12 text-center">
            <div class="w-16 h-16 rounded-full border-4 border-purple-700 border-t-transparent animate-spin mx-auto mb-6"></div>
            <h2 class="page-title text-3xl sm:text-4xl mb-4">Analyzing your event requirements...</h2>
            <p class="section-subtitle">Preparing your quotation. This may take a moment.</p>
        </div>

        <div id="quotationState" class="hidden">
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
                                <div class="flex-1 rounded-xl bg-amber-100/60 text-amber-700 font-medium py-3 text-center flex justify-center items-center uppercase text-sm">
                                    Request Submitted Successfully
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 text-center mt-4">An admin will review your request and contact you at {{ $booking->guest_email }} or {{ $booking->guest_phone }} shortly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
