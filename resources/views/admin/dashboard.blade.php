<x-admin-layout title="Admin Dashboard">
    <!-- Statistics Cards: Summary metrics for admin monitoring -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Bookings Card: Shows booking count -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-days text-purple-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Bookings</p>
                    <p class="serif text-2xl font-bold text-purple-900">24</p>
                </div>
            </div>
        </div>
        <!-- Pending Bookings Card: Shows pending booking count -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-yellow-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Pending Bookings</p>
                    <p class="serif text-2xl font-bold text-purple-900">8</p>
                </div>
            </div>
        </div>
        <!-- Total Users Card: Shows user count -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-green-700 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Users</p>
                    <p class="serif text-2xl font-bold text-purple-900">156</p>
                </div>
            </div>
        </div>
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
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">John Doe</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Wedding</td>
                        <td class="px-6 py-4 text-sm text-gray-600">June 15, 2026</td>
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