<x-admin-layout active="settings">
    <!-- Main Content wrapper matching other admin pages -->
    <div class="space-y-6">
        
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pre-Set Packages</h1>
                <p class="text-sm text-slate-500 mt-1">Manage public booking packages and their pricing.</p>
            </div>
            <!-- Add Package Button triggers a modal or form. For simplicity, we use a toggleable form below -->
            <button onclick="document.getElementById('createForm').classList.toggle('hidden')" class="btn-primary">
                + New Package
            </button>
        </div>

        @if(session('success'))
            <div class="bg-[#DEF7EC] border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-[#FDE8E8] border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Form (Hidden by default) -->
        <div id="createForm" class="hidden bg-white p-6 rounded-2xl shadow-sm border border-[#E7E2F0]">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Create New Package</h2>
            <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Price (₱)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Included Items (Comma separated)</label>
                    <input type="text" name="included_items" class="form-control" placeholder="e.g. 50 Red Roses, 1 Bridal Bouquet, Venue Setup">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Display Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-slate-300 text-[#5E3B82] focus:ring-[#5E3B82]">
                        <label for="is_active" class="text-sm font-medium text-slate-700">Active (Visible to Public)</label>
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-[#5E3B82] hover:bg-[#4A2E68] text-white px-6 py-2 rounded-xl text-sm font-medium transition">Save Package</button>
                </div>
            </form>
        </div>

        <!-- Packages Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-[#E7E2F0] overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-[#E7E2F0] text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Package</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E7E2F0]">
                    @forelse($packages as $package)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($package->image_path)
                                        <img src="{{ asset('storage/' . $package->image_path) }}" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $package->title }}</p>
                                        <p class="text-xs text-slate-500 truncate max-w-xs">{{ $package->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                ₱{{ number_format($package->price, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($package->is_active)
                                    <span class="bg-[#DEF7EC] text-green-800 text-xs px-2.5 py-1 rounded-[20px] font-medium">Active</span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-[20px] font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="document.getElementById('edit-{{ $package->id }}').classList.toggle('hidden')" class="text-[#5E3B82] hover:text-[#4A2E68] text-sm font-medium">Edit</button>
                                    <form action="{{ route('packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Delete this package?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Form Row (Hidden) -->
                        <tr id="edit-{{ $package->id }}" class="hidden bg-slate-50 border-b border-[#E7E2F0]">
                            <td colspan="4" class="px-6 py-6">
                                <form action="{{ route('packages.update', $package) }}" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-3xl">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Title</label>
                                            <input type="text" name="title" value="{{ $package->title }}" class="form-control" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Price (₱)</label>
                                            <input type="number" step="0.01" name="price" value="{{ $package->price }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Description</label>
                                        <textarea name="description" class="form-control" rows="2">{{ $package->description }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-700 mb-1">Included Items (Comma separated)</label>
                                        <input type="text" name="included_items" value="{{ is_array($package->included_items) ? implode(', ', $package->included_items) : '' }}" class="form-control">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Update Image</label>
                                            <input type="file" name="image" class="form-control text-xs" accept="image/*">
                                        </div>
                                        <div class="flex items-center gap-2 mt-4">
                                            <input type="checkbox" name="is_active" id="is_active_{{ $package->id }}" value="1" {{ $package->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-[#5E3B82] focus:ring-[#5E3B82]">
                                            <label for="is_active_{{ $package->id }}" class="text-xs font-medium text-slate-700">Active</label>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2 pt-2">
                                        <button type="button" onclick="document.getElementById('edit-{{ $package->id }}').classList.add('hidden')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-xl text-xs font-medium hover:bg-slate-50">Cancel</button>
                                        <button type="submit" class="bg-[#5E3B82] hover:bg-[#4A2E68] text-white px-4 py-2 rounded-xl text-xs font-medium">Update Package</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                No packages created yet. Click "New Package" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
