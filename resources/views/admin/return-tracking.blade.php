<x-admin-layout title="Return Tracking">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-purple-900 mb-4">Assets on Loan</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Asset</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">Ceramic Vase Set</td>
                        <td class="px-6 py-4 text-sm text-gray-600">June Wedding</td>
                        <td class="px-6 py-4 text-sm text-gray-600">June 22, 2026</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center rounded-full bg-amber-100 text-amber-800 px-3 py-1 text-xs">Due Soon</span></td>
                        <td class="px-6 py-4"><button class="text-purple-600 hover:text-purple-800 text-sm font-semibold">Update</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-600">Total Items Out</p>
            <p class="serif text-3xl font-bold text-purple-900 mt-3">12</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-600">Overdue Returns</p>
            <p class="serif text-3xl font-bold text-red-700 mt-3">3</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-600">Pending Inspections</p>
            <p class="serif text-3xl font-bold text-purple-900 mt-3">5</p>
        </div>
    </div>
</x-admin-layout>