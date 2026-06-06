<x-admin-layout title="Bookings Management">
    <!-- Filter Controls: Status filter dropdown -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <!-- Status Filter: Dropdown to filter bookings by status -->
            <select class="border border-purple-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                <option>All Status</option>
                <option>Pending</option>
                <option>Confirmed</option>
                <option>Completed</option>
            </select>
        </div>
        <button class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            <i class="fa-solid fa-plus mr-1"></i> New Booking
        </button>
    </div>

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
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">John Doe</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Wedding</td>
                        <td class="px-6 py-4 text-sm text-gray-600">June 15, 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Sheraton Manila</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span></td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.bookings.show', 1) }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">Review</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>