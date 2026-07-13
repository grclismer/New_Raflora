<x-admin-layout title="Admin Dashboard">
    <!-- Statistics Cards: Summary metrics for admin monitoring -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-days text-purple-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Bookings</p>
                    <p class="serif text-2xl font-bold text-purple-900">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-yellow-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Pending Bookings</p>
                    <p class="serif text-2xl font-bold text-purple-900">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-green-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Users</p>
                    <p class="serif text-2xl font-bold text-purple-900">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions: Direct admin shortcuts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('admin.bookings') }}" class="group block bg-white rounded-lg shadow p-6 border border-purple-100 hover:border-purple-300 transition">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Quick action</p>
                    <h3 class="text-lg font-semibold text-purple-900">Review Bookings</h3>
                </div>
                <i class="fa-solid fa-arrow-right text-purple-600 group-hover:text-purple-800"></i>
            </div>
            <p class="mt-4 text-sm text-gray-500">Open the booking queue and verify payment references.</p>
        </a>
        <a href="{{ route('admin.quotations') }}" class="group block bg-white rounded-lg shadow p-6 border border-purple-100 hover:border-purple-300 transition">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Quick action</p>
                    <h3 class="text-lg font-semibold text-purple-900">Manage Quotations</h3>
                </div>
                <i class="fa-solid fa-file-invoice-dollar text-purple-600 group-hover:text-purple-800"></i>
            </div>
            <p class="mt-4 text-sm text-gray-500">Review price estimates and confirm quotation details with clients.</p>
        </a>
        <a href="{{ route('admin.ai-analysis') }}" class="group block bg-white rounded-lg shadow p-6 border border-purple-100 hover:border-purple-300 transition">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Quick action</p>
                    <h3 class="text-lg font-semibold text-purple-900">AI Material Plan</h3>
                </div>
                <i class="fa-solid fa-brain text-purple-600 group-hover:text-purple-800"></i>
            </div>
            <p class="mt-4 text-sm text-gray-500">See latest AI-suggested materials and update procurement plans.</p>
        </a>
    </div>

    <!-- Recent Bookings Table: Lists latest booking requests -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b border-purple-100">
            <h2 class="serif text-lg font-bold text-purple-900">Recent Bookings</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Event Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $booking->client?->full_name ?? 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($booking->event_type) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ optional($booking->event_date)->format('F j, Y') }}</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span></td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">Review</a>
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