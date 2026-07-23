<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index(): View
    {
        $packages = Package::all();
        return view('admin.packages', ['packages' => $packages]);
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'included_items' => 'nullable|string', // Comma separated for now
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
        }

        $items = array_filter(array_map('trim', explode(',', $validated['included_items'] ?? '')));

        Package::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'included_items' => $items,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Package created successfully.');
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'included_items' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image_path) {
                Storage::disk('public')->delete($package->image_path);
            }
            $package->image_path = $request->file('image')->store('packages', 'public');
        }

        $items = array_filter(array_map('trim', explode(',', $validated['included_items'] ?? '')));

        $package->title = $validated['title'];
        $package->description = $validated['description'];
        $package->price = $validated['price'];
        $package->included_items = $items;
        $package->is_active = $request->has('is_active');
        $package->save();

        return back()->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        if ($package->image_path) {
            Storage::disk('public')->delete($package->image_path);
        }
        $package->delete();

        return back()->with('success', 'Package deleted successfully.');
    }
}
