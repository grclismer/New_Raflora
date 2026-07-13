<x-admin-layout title="Bookings Management">
    <!-- Filter Controls: Status filter dropdown -->
    <form method="GET" action="{{ route('admin.bookings') }}" class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <label for="status" class="text-sm text-gray-700">Status</label>
            <select id="status" name="status" class="border border-purple-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="quotation_sent" {{ $statusFilter === 'quotation_sent' ? 'selected' : '' }}>Quotation Sent</option>
                <option value="payment_pending" {{ $statusFilter === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                <option value="downpayment_received" {{ $statusFilter === 'downpayment_received' ? 'selected' : '' }}>Downpayment Received</option>
                <option value="completed" {{ $statusFilter === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="declined" {{ $statusFilter === 'declined' ? 'selected' : '' }}>Declined</option>
                <option value="cancelled" {{ $statusFilter === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Filter</button>
        </div>
    </form>

    <!-- Bookings Table: Lists all bookings for admin review -->
    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Event Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Venue</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $booking->client?->full_name ?? 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($booking->event_type) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ optional($booking->event_date)->format('F j, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->venue }}</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span></td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.bookings.show', ['booking' => $booking->id]) }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">No bookings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>