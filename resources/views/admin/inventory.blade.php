<x-admin-layout title="Inventory Management">
    <!-- Filter Controls: Category filter dropdown -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <!-- Category Filter: Dropdown to filter inventory by category -->
            <select class="border border-purple-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                <option>All Categories</option>
                <option>Flowers</option>
                <option>Decorations</option>
                <option>Equipment</option>
            </select>
        </div>
        <button class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            <i class="fa-solid fa-plus mr-1"></i> Add Item
        </button>
    </div>

    <!-- Inventory Table: Lists all inventory items -->
    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-purple-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Stock Level</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-purple-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-100">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-800">Rose Bouquet</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Flowers</td>
                        <td class="px-6 py-4 text-sm text-gray-600">45</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">In Stock</span></td>
                        <td class="px-6 py-4">
                            <button class="text-purple-600 hover:text-purple-800 text-sm font-semibold">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>