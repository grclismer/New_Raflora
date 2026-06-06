<x-admin-layout title="Booking Review">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-purple-900">June Wedding - John Doe</h2>
                <p class="text-sm text-gray-600">Review booking details and confirm status.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded-lg">Approve</button>
                <button class="bg-white border border-purple-200 text-purple-700 px-4 py-2 rounded-lg">Request Changes</button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-purple-900 mb-4">Booking Summary</h3>
            <ul class="space-y-3 text-sm text-gray-700">
                <li><strong>Client:</strong> John Doe</li>
                <li><strong>Event Type:</strong> Wedding</li>
                <li><strong>Date:</strong> June 15, 2026</li>
                <li><strong>Venue:</strong> Sheraton Manila</li>
                <li><strong>Guests:</strong> 120</li>
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6 xl:col-span-2">
            <h3 class="text-lg font-semibold text-purple-900 mb-4">Review Notes</h3>
            <p class="text-sm text-gray-600 mb-4">This page is for administrative review, price reconfirmation, and finishing the booking details before final confirmation.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-3xl bg-purple-50 p-4">
                    <p class="text-sm font-semibold text-purple-900">Current Status</p>
                    <p class="mt-2 text-lg font-bold text-purple-900">Pending</p>
                </div>
                <div class="rounded-3xl bg-purple-50 p-4">
                    <p class="text-sm font-semibold text-purple-900">Estimated Price</p>
                    <p class="mt-2 text-lg font-bold text-purple-900">₱12,450</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>