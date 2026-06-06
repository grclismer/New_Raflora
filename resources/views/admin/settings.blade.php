<x-admin-layout title="System Settings">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-purple-900 mb-4">General Settings</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-100" value="Raflora Enterprises">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notification Email</label>
                    <input type="email" class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-100" value="admin@raflora.com">
                </div>
                <button class="mt-4 bg-purple-700 hover:bg-purple-800 text-white px-5 py-3 rounded-lg font-semibold">Save Settings</button>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-purple-900 mb-4">System Preferences</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between gap-4 rounded-xl border border-gray-200 p-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Email Notifications</p>
                        <p class="text-sm text-gray-600">Receive alerts for bookings and inventory updates.</p>
                    </div>
                    <input type="checkbox" class="h-5 w-5 text-purple-700 rounded border-gray-300 focus:ring-purple-500">
                </div>
                <div class="flex items-center justify-between gap-4 rounded-xl border border-gray-200 p-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Low Stock Alerts</p>
                        <p class="text-sm text-gray-600">Enable shortage notifications for inventory items.</p>
                    </div>
                    <input type="checkbox" class="h-5 w-5 text-purple-700 rounded border-gray-300 focus:ring-purple-500" checked>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>