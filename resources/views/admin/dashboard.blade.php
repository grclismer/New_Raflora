<x-admin-layout title="Admin Dashboard">
    <!-- Statistics Cards: Summary metrics for admin monitoring -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-days text-purple-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-amber-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Bookings</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-emerald-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions: Direct admin shortcuts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('admin.bookings') }}" class="group block bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-purple-500 mb-2 font-semibold">Quick action</p>
                    <h3 class="text-lg font-bold text-gray-800">Review Bookings</h3>
                </div>
                <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-purple-600 transition"></i>
            </div>
            <p class="mt-3 text-sm text-gray-500">Open the booking queue and verify payment references.</p>
        </a>
        <a href="{{ route('admin.quotations') }}" class="group block bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-purple-500 mb-2 font-semibold">Quick action</p>
                    <h3 class="text-lg font-bold text-gray-800">Manage Quotations</h3>
                </div>
                <i class="fa-solid fa-file-invoice-dollar text-gray-400 group-hover:text-purple-600 transition"></i>
            </div>
            <p class="mt-3 text-sm text-gray-500">Review price estimates and confirm quotation details with clients.</p>
        </a>
        <a href="{{ route('admin.ai-analysis') }}" class="group block bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-purple-500 mb-2 font-semibold">Quick action</p>
                    <h3 class="text-lg font-bold text-gray-800">AI Material Plan</h3>
                </div>
                <i class="fa-solid fa-brain text-gray-400 group-hover:text-purple-600 transition"></i>
            </div>
            <p class="mt-3 text-sm text-gray-500">See latest AI-suggested materials and update procurement plans.</p>
        </a>
    </div>

    <!-- Recent Bookings Table: Lists latest booking requests -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Recent Bookings</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs uppercase tracking-wider text-gray-500 font-semibold">Client</th>
                        <th class="px-6 py-3 text-xs uppercase tracking-wider text-gray-500 font-semibold">Event Type</th>
                        <th class="px-6 py-3 text-xs uppercase tracking-wider text-gray-500 font-semibold">Date</th>
                        <th class="px-6 py-3 text-xs uppercase tracking-wider text-gray-500 font-semibold">Status</th>
                        <th class="px-6 py-3 text-xs uppercase tracking-wider text-gray-500 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $booking->client?->full_name ?? 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($booking->event_type) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ optional($booking->event_date)->format('M j, Y') }}</td>
                            <td class="px-6 py-4">
                                @if($booking->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span>
                                @elseif($booking->status === 'quotation_sent')
                                    <span class="bg-indigo-100 text-indigo-800 text-xs px-2.5 py-1 rounded-full font-medium">Quotation Sent</span>
                                @elseif($booking->status === 'completed' || $booking->status === 'confirmed' || $booking->status === 'downpayment_received')
                                    <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-medium">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-1 rounded-full font-medium">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-purple-600 hover:text-purple-900 font-semibold text-sm hover:underline transition">Review &rarr;</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">No recent bookings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>