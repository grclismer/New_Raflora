<x-admin-layout title="Booking Review">
    <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-purple-900">Booking #{{ $booking->id }} - {{ ucfirst($booking->event_type) }} (Client: {{ $booking->client?->full_name ?? 'Guest' }})</h2>
            <p class="mt-2">
                @if($booking->status === 'pending')
                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                        Pending Admin Review
                    </span>
                @else
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                        {{ str_replace('_', ' ', $booking->status) }}
                    </span>
                @endif
            </p>
        </div>
        <a href="{{ route('admin.bookings') }}" class="bg-white border border-purple-200 text-purple-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-50 transition">
            &larr; Back to Bookings
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.bookings.update', ['booking' => $booking->id]) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Pass hidden required fields to avoid validation errors if they aren't rendered in new layout -->
        <input type="hidden" name="event_type" value="{{ $booking->event_type }}">
        <input type="hidden" name="event_date" value="{{ optional($booking->event_date)->format('Y-m-d') }}">
        <input type="hidden" name="venue" value="{{ $booking->venue }}">
        <input type="hidden" name="status" value="{{ $booking->status }}">

        <!-- SECTION 1: CLIENT REQUEST & INSPIRATION -->
        <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-purple-50 pb-2">Event Details & Inspiration</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <!-- Inspiration Image -->
                <div class="col-span-1 rounded-lg overflow-hidden bg-slate-50 border border-slate-200">
                    @if($booking->inspiration_image)
                        <div class="aspect-[4/5] relative">
                            <img src="{{ asset('storage/' . $booking->inspiration_image) }}" alt="Inspiration Image" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-[4/5] flex items-center justify-center">
                            <span class="text-slate-400 text-sm">No Image Provided</span>
                        </div>
                    @endif
                </div>
                
                <!-- Booking Details -->
                <div class="col-span-2 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-semibold">Event Date</p>
                            <p class="text-slate-800 font-medium">{{ optional($booking->event_date)->format('F j, Y') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-semibold">Venue</p>
                            <p class="text-slate-800 font-medium">{{ $booking->venue ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Special Request Notes from Client</p>
                        <div class="bg-slate-50 p-4 rounded-lg text-sm text-slate-700 border border-slate-100 min-h-[5rem]">
                            {{ $booking->special_requests ?: 'No special requests provided.' }}
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Admin Internal Notes (Optional)</p>
                        <textarea name="admin_note" rows="2" class="w-full border border-purple-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 placeholder-slate-400" placeholder="Add internal notes about stock or client here...">{{ old('admin_note', $booking->cancellation_reason) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: ITEM & PRICING BREAKDOWN -->
        <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-purple-50 pb-2">Item & Pricing Breakdown</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-purple-50 text-purple-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 rounded-tl-lg font-semibold">Item Name</th>
                            <th class="px-4 py-3 font-semibold">Qty</th>
                            <th class="px-4 py-3 font-semibold">Unit Cost (₱)</th>
                            <th class="px-4 py-3 font-semibold">Total Cost (₱)</th>
                            <th class="px-4 py-3 rounded-tr-lg font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-purple-50">
                        @php
                            $itemsToDisplay = [];
                            if ($booking->inventoryItems->count() > 0) {
                                foreach ($booking->inventoryItems as $inv) {
                                    $itemsToDisplay[] = [
                                        'name' => $inv->name,
                                        'qty' => $inv->pivot->quantity,
                                        'unit_price' => $inv->pivot->quoted_unit_price,
                                    ];
                                }
                            } elseif ($analysis) {
                                foreach ($analysis->suggested_materials as $item) {
                                    $itemsToDisplay[] = [
                                        'name' => $item['item_name'] ?? 'Unknown Item',
                                        'qty' => $item['estimated_quantity'] ?? 1,
                                        'unit_price' => $item['estimated_unit_cost_php'] ?? 0,
                                    ];
                                }
                            }
                        @endphp
                        
                        @forelse($itemsToDisplay as $idx => $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-slate-800 text-sm">{{ $item['name'] }}</span>
                                    <input type="hidden" name="items[{{ $idx }}][item_name]" value="{{ $item['name'] }}">
                                </td>
                                <td class="px-4 py-3 w-28">
                                    <input type="number" name="items[{{ $idx }}][quantity]" min="0" value="{{ $item['qty'] }}" class="w-full border border-slate-300 rounded px-2 py-1.5 text-sm focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                                </td>
                                <td class="px-4 py-3 w-36">
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">₱</span>
                                        <input type="number" step="0.01" name="items[{{ $idx }}][unit_price]" min="0" value="{{ $item['unit_price'] }}" class="w-full border border-slate-300 rounded pl-7 pr-2 py-1.5 text-sm focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-slate-700 font-medium text-sm">
                                    ₱ {{ number_format($item['qty'] * $item['unit_price'], 2) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer text-red-500 hover:text-red-700 transition">
                                        <input type="checkbox" name="items[{{ $idx }}][remove]" value="1" class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500 mr-1.5">
                                        <span class="text-xs font-semibold uppercase">Remove</span>
                                    </label>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500 text-sm">No items suggested or added.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 bg-slate-50 rounded-lg border border-slate-200 p-5 w-full max-w-md ml-auto">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-slate-600">Raw Wholesale Subtotal (BOM Cost):</span>
                    <span class="font-medium text-slate-800">₱ {{ number_format($booking->raw_materials_sum ?? 0, 2) }}</span>
                </div>
                
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-slate-600">Markup Multiplier:</span>
                    <input type="number" step="0.1" name="multiplier" value="{{ old('multiplier', $booking->multiplier ?? 3.0) }}" class="w-24 text-right border border-slate-300 rounded px-2 py-1 text-sm focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                </div>
                
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-slate-600">Calculated Quotation Total:</span>
                    <span class="font-medium text-slate-800">₱ {{ number_format(($booking->raw_materials_sum ?? 0) * ($booking->multiplier ?? 3.0), 2) }}</span>
                </div>
                
                <div class="border-t border-slate-200 pt-3 mt-3 flex justify-between items-center">
                    <span class="text-sm font-semibold text-slate-800">Final Quoted Total (Override):</span>
                    <div class="relative w-32">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm font-medium">₱</span>
                        <input type="number" step="0.01" name="final_quoted_price" value="{{ old('final_quoted_price', $booking->final_quoted_price ?: $booking->total_quoted) }}" class="w-full border border-purple-300 bg-white rounded pl-7 pr-2 py-1.5 font-bold text-purple-700 text-right focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: ACTION BUTTONS (BOTTOM) -->
        <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6 flex flex-wrap items-center justify-end gap-4">
            <button type="submit" name="action" value="save" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-6 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">
                Save Draft / Updates
            </button>
            <button type="submit" name="action" value="send_quotation" class="bg-purple-700 hover:bg-purple-800 text-white px-8 py-2.5 rounded-lg text-sm font-bold transition shadow-sm">
                Approve & Send Official Quote to Client
            </button>
        </div>
    </form>
    
    <!-- Decline Form Separated -->
    <form method="POST" action="{{ route('admin.bookings.decline', ['booking' => $booking->id]) }}" class="mt-4 flex justify-end">
        @csrf
        <!-- You could include a decline reason modal or text input here if needed, but for simplicity we keep the button isolated -->
        <button type="submit" onclick="return confirm('Are you sure you want to reject this booking?')" class="bg-white border-2 border-red-200 hover:bg-red-50 text-red-600 px-6 py-2.5 rounded-lg text-sm font-bold transition">
            Reject / Decline Booking
        </button>
    </form>

</x-admin-layout>