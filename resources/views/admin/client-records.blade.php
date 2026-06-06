<x-admin-layout title="Client Records">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-purple-900 mb-4">Client Records</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Client Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Bookings</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Last Activity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">Jane Santos</td>
                        <td class="px-6 py-4 text-sm text-gray-600">jane.santos@example.com</td>
                        <td class="px-6 py-4 text-sm text-gray-600">6</td>
                        <td class="px-6 py-4 text-sm text-gray-600">May 28, 2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>