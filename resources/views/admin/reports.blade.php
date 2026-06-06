<x-admin-layout title="Reports & Audit Logs">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Bookings This Month</p>
            <p class="serif text-3xl font-bold text-purple-900 mt-3">128</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Revenue Estimate</p>
            <p class="serif text-3xl font-bold text-purple-900 mt-3">₱356,000</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Stock Alerts</p>
            <p class="serif text-3xl font-bold text-red-700 mt-3">4</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-purple-900 mb-4">Activity Log</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">June 01, 2026</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Admin</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Updated Booking Status</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Booking #102 changed to Confirmed</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>