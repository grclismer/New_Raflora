<x-admin-layout title="AI Analysis">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-purple-900 mb-3">Image Review</h2>
            <div class="rounded-3xl overflow-hidden border border-purple-100">
                <img src="{{ asset('assets/images/gallery/image1.jpg') }}" alt="Client Reference" class="w-full h-48 object-cover">
            </div>
            <p class="text-sm text-gray-600 mt-4">Review client-submitted event inspiration images and compare to AI recommendations.</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 xl:col-span-2">
            <h2 class="text-lg font-semibold text-purple-900 mb-3">Suggested Floral Materials</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-2xl bg-purple-50 p-4">
                    <p class="text-sm font-semibold text-purple-900">Primary Flowers</p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-700">
                        <li>Roses</li>
                        <li>Hydrangeas</li>
                        <li>Baby's breath</li>
                    </ul>
                </div>
                <div class="rounded-2xl bg-purple-50 p-4">
                    <p class="text-sm font-semibold text-purple-900">Accent Materials</p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-700">
                        <li>Eucalyptus foliage</li>
                        <li>Ribbon accents</li>
                        <li>Decorative branches</li>
                    </ul>
                </div>
            </div>
            <div class="mt-6 bg-white rounded-3xl border border-purple-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-gray-600">Estimated Total Cost</p>
                        <p class="text-3xl font-bold text-purple-900">₱12,450</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-800 px-3 py-1 text-sm">Verified</span>
                </div>
                <p class="text-sm text-gray-600">Use this recommendation to finalize the quotation and confirm item availability.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-purple-900 mb-3">Review Notes</h2>
        <textarea class="w-full rounded-2xl border border-purple-100 p-4 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-200" rows="5" placeholder="Add review comments for the design team..."></textarea>
    </div>
</x-admin-layout>