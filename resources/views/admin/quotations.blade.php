<x-admin-layout title="Quotations">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-purple-900 mb-4">Pending Quotations</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Estimate</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">June Wedding</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Jane Santos</td>
                        <td class="px-6 py-4 text-sm text-gray-600">₱15,200</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-800 px-3 py-1 text-xs">Review</span></td>
                        <td class="px-6 py-4"><button class="text-purple-600 hover:text-purple-800 text-sm font-semibold">Finalize</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-semibold text-purple-700 uppercase mb-3">Price Reconfirmation Notes</h3>
        <p class="text-gray-600 text-sm">Review current stock availability and adjust quotation details before sending a final confirmation to the client.</p>
    </div>
</x-admin-layout>