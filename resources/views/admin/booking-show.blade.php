<x-admin-layout title="Booking Review">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-purple-900">{{ ucfirst($booking->event_type) }} - {{ $booking->client?->full_name ?? 'Guest' }}</h2>
                <p class="text-sm text-gray-600">Review booking details, update status, or make edits.</p>
            </div>
            <a href="{{ route('admin.bookings') }}" class="bg-white border border-purple-200 text-purple-700 px-4 py-2 rounded-lg text-sm font-semibold">Back to Bookings</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.bookings.update', ['booking' => $booking->id]) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-purple-900 mb-4">Booking Summary</h3>
                <ul class="space-y-3 text-sm text-gray-700">
                    <li><strong>Client:</strong> {{ $booking->client?->full_name ?? 'Guest' }}</li>
                    <li><strong>Email:</strong> {{ $booking->client?->email ?? 'N/A' }}</li>
                    <li><strong>Phone:</strong> {{ $booking->client?->phone ?? 'N/A' }}</li>
                    <li><strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($booking->status)) }}</li>
                    <li><strong>Created:</strong> {{ optional($booking->created_at)->format('F j, Y') }}</li>
                    @if($booking->cancellation_reason)
                        <li><strong>Admin Notes:</strong> {{ $booking->cancellation_reason }}</li>
                    @endif
                </ul>
            </div>
            <div class="bg-white rounded-lg shadow p-6 xl:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Event Type</span>
                        <select name="event_type" class="mt-2 w-full border border-purple-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500">
                            <option value="wedding" {{ $booking->event_type === 'wedding' ? 'selected' : '' }}>Wedding</option>
                            <option value="corporate" {{ $booking->event_type === 'corporate' ? 'selected' : '' }}>Corporate</option>
                            <option value="birthday" {{ $booking->event_type === 'birthday' ? 'selected' : '' }}>Birthday</option>
                            <option value="other" {{ $booking->event_type === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Event Date</span>
                        <input type="date" name="event_date" value="{{ optional($booking->event_date)->format('Y-m-d') }}" class="mt-2 w-full border border-purple-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500">
                    </label>
                </div>

                <label class="block mt-4">
                    <span class="text-gray-700 text-sm font-semibold">Venue</span>
                    <input type="text" name="venue" value="{{ $booking->venue }}" class="mt-2 w-full border border-purple-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500">
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700 text-sm font-semibold">Special Requests</span>
                    <textarea name="special_requests" rows="4" class="mt-2 w-full border border-purple-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500">{{ $booking->special_requests }}</textarea>
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700 text-sm font-semibold">Booking Status</span>
                    <select name="status" class="mt-2 w-full border border-purple-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500">
                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="quotation_sent" {{ $booking->status === 'quotation_sent' ? 'selected' : '' }}>Quotation Sent</option>
                        <option value="payment_pending" {{ $booking->status === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                        <option value="downpayment_received" {{ $booking->status === 'downpayment_received' ? 'selected' : '' }}>Downpayment Received</option>
                        <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="declined" {{ $booking->status === 'declined' ? 'selected' : '' }}>Declined</option>
                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-2">Update this status to accept the booking, send a quotation, mark payment received, or cancel/decline before notifying the client.</p>
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700 text-sm font-semibold">Admin Review Notes / Item Issues</span>
                    <p class="text-xs text-gray-500 mt-1">Use this field to record unavailable items, quantity changes, or special requirements before updating the booking status or notifying the client.</p>
                    <textarea name="admin_note" rows="5" class="mt-2 w-full border border-purple-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500">{{ old('admin_note', $booking->cancellation_reason) }}</textarea>
                </label>

                <div class="mt-6 flex gap-3">
                    <button type="submit" name="action" value="save" class="inline-flex items-center justify-center bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-lg text-sm font-semibold transition">
                        Save Booking Changes
                    </button>
                    <button type="submit" name="action" value="send_quotation" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-lg text-sm font-semibold transition">Send Quotation</button>
                    <button type="submit" name="action" value="accept" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg text-sm font-semibold transition">Accept Booking</button>
                </div>
            </div>
        </div>
        
        @if($analysis)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-purple-900 mb-4">Review Suggested Items</h3>
                <p class="text-sm text-gray-500 mb-3">Adjust quantities or mark items as unavailable. These notes will be saved to the admin review notes.</p>
                <div class="space-y-3">
                    @foreach($analysis->suggested_materials as $idx => $item)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-b border-purple-50 py-3">
                            <div>
                                <p class="text-sm font-semibold">{{ $item['item_name'] }}</p>
                                <p class="text-xs text-gray-600">Category: {{ ucfirst($item['category']) }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Adjusted Quantity</label>
                                <input type="number" name="items[{{ $idx }}][adjusted_quantity]" min="0" value="{{ $item['estimated_quantity'] }}" class="mt-1 w-32 border border-purple-200 rounded px-3 py-2 text-sm">
                                <input type="hidden" name="items[{{ $idx }}][item_name]" value="{{ $item['item_name'] }}">
                            </div>
                            <div>
                                <label class="inline-flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="items[{{ $idx }}][unavailable]" value="1" class="w-4 h-4">
                                    <span class="text-sm text-gray-700">Mark Unavailable</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </form>

    <div class="mt-4">
        <form method="POST" action="{{ route('admin.bookings.decline', ['booking' => $booking->id]) }}">
            @csrf
            <label class="block">
                <span class="text-gray-700 text-sm font-semibold">Decline Reason (optional)</span>
                <textarea name="admin_note" rows="3" class="mt-2 w-full border border-red-200 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-red-500"></textarea>
            </label>
            <button type="submit" class="mt-3 inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">Decline Booking</button>
        </form>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-4">AI Analysis</h3>
            <p class="text-sm text-gray-500 mb-4">Review the suggested items and note any availability issues or quantity changes in the admin review field above.</p>
            @if($analysis)
                <div class="space-y-3">
                    @foreach($analysis->suggested_materials as $item)
                        <div class="rounded-lg bg-purple-50 p-4">
                            <p class="text-sm font-semibold text-purple-900">{{ $item['item_name'] }}</p>
                            <p class="text-xs text-gray-600">Category: {{ ucfirst($item['category']) }} · Quantity: {{ $item['estimated_quantity'] }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-600">No AI analysis results found for this booking.</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-4">Payment & Quotation</h3>
            <p class="text-sm text-gray-600 mb-3"><strong>Quoted Total:</strong> ₱{{ number_format($booking->total_quoted ?? 0, 2) }}</p>
            <p class="text-sm text-gray-600 mb-3"><strong>Payment Status:</strong> {{ $payment?->status ? ucfirst(str_replace('_', ' ', $payment->status)) : 'No payment submitted' }}</p>
            @if($payment)
                <p class="text-sm text-gray-600 mb-1"><strong>Reference:</strong> {{ $payment->reference_number }}</p>
                <p class="text-sm text-gray-600"><strong>Method:</strong> {{ strtoupper(str_replace('_', ' ', $payment->payment_type)) }}</p>

                @if($payment->status === 'pending')
                    <form method="POST" action="{{ route('admin.payments.verify', ['payment' => $payment->id]) }}" class="mt-4">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">Verify Payment</button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>