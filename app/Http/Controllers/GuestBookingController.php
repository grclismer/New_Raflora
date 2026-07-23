<?php

namespace App\Http\Controllers;

use App\Models\AiAnalysisResult;
use App\Models\Booking;
use App\Models\InventoryItem;
use App\Models\Package;
use App\Services\GeminiVisionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class GuestBookingController extends Controller
{
    /**
     * Show the guest booking creation form.
     */
    public function create(): View
    {
        $packages = Package::where('is_active', true)->get();

        return view('guest.booking-create', [
            'packages' => $packages,
        ]);
    }

    /**
     * Store a new guest booking.
     */
    public function store(Request $request): RedirectResponse
    {
        set_time_limit(120);

        // Normalize venue field if passed as venue_address
        if (!$request->has('venue') && $request->has('venue_address')) {
            $request->merge(['venue' => $request->input('venue_address')]);
        }

        $bookingType = $request->input('booking_type', 'custom_ai');

        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:20'],
            'guest_address' => ['nullable', 'string', 'max:500'],
            'booking_type' => ['nullable', 'string', 'in:custom_ai,preset'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'event_type' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'event_time' => ['nullable', 'date_format:H:i'],
            'venue' => ['required', 'string', 'max:500'],
            'special_requests' => ['nullable', 'string', 'max:2000'],
            'inspiration_image' => ['nullable', 'image', 'max:5120'], // 5MB max
        ]);

        $inspirationImagePath = null;
        if ($request->hasFile('inspiration_image')) {
            $inspirationImagePath = $request->file('inspiration_image')->store('bookings/inspiration-images', 'public');
        }

        $priceValidUntil = Carbon::now()->addDays(7)->toDateString();
        $suggestedProcurement = Carbon::parse($validated['event_date'])->subDays(7)->toDateString();

        $selectedPackage = null;
        if ($bookingType === 'preset' && !empty($validated['package_id'])) {
            $selectedPackage = Package::find($validated['package_id']);
        }

        $specialRequests = $validated['special_requests'] ?? '';
        if ($selectedPackage) {
            $specialRequests = trim($specialRequests . "\nSelected Package: " . $selectedPackage->title . " (₱" . number_format($selectedPackage->price, 2) . ")");
        }

        $booking = Booking::create([
            'client_id' => null, // Guest
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'guest_address' => $validated['guest_address'],
            'handled_by' => null,
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'] ?? null,
            'venue' => $validated['venue'],
            'special_requests' => $specialRequests,
            'inspiration_image' => $inspirationImagePath ?? ($selectedPackage?->image_path),
            'status' => 'pending',
            'total_quoted' => $selectedPackage ? $selectedPackage->price : 0,
            'raw_materials_sum' => $selectedPackage ? $selectedPackage->price : 0,
            'multiplier' => 1.0,
            'final_quoted_price' => $selectedPackage ? $selectedPackage->price : 0,
            'price_valid_until' => $priceValidUntil,
            'suggested_procurement_date' => $suggestedProcurement,
        ]);

        // If a package was selected, skip AI vision analysis
        if ($selectedPackage) {
            return redirect()->route('guest.booking.analysis', ['booking' => $booking->id])
                ->with('success', 'Package booking request created successfully!');
        }

        // Run Gemini AI Vision Analysis for custom requests
        try {
            if ($inspirationImagePath) {
                $fullPath = storage_path('app/public/' . $inspirationImagePath);
            } else {
                $fullPath = null;
            }

            if (!empty($fullPath) && file_exists($fullPath)) {
                $vision = new GeminiVisionService();
                try {
                    $result = $vision->analyzeImageFromPath(
                        $fullPath,
                        $validated['special_requests'] ?? null,
                        $validated['event_type'] ?? null,
                        $validated['event_time'] ?? null,
                        $validated['venue'] ?? null
                    );

                    $materials = $result['analysis']['suggested_materials'] ?? [];
                } catch (\Throwable $e) {
                    Log::error('Guest Gemini Execution Failed: ' . $e->getMessage());
                    throw $e;
                }

                $analysisModel = AiAnalysisResult::create([
                    'booking_id' => $booking->id,
                    'raw_gemini_response' => is_array($result['raw_response']) ? json_encode($result['raw_response']) : $result['raw_response'],
                    'suggested_materials' => $materials,
                    'analyzed_at' => Carbon::now(),
                ]);

                if (is_array($materials) && count($materials) > 0) {
                    $totalCost = 0;
                    foreach ($materials as $mat) {
                        $itemName = $mat['item_name'] ?? null;
                        if (!$itemName) continue;

                        $quantity = (float)($mat['estimated_quantity'] ?? 1);
                        $unitCost = (float)($mat['estimated_unit_cost_php'] ?? $mat['estimated_unit_cost'] ?? 0);
                        if ($quantity <= 0 || $unitCost <= 0) {
                            continue;
                        }

                        $totalCost += $quantity * $unitCost;
                        $category = $mat['category'] ?? 'flower';
                        $unitType = $mat['unit_type'] ?? 'stem';

                        $inventory = InventoryItem::firstOrCreate(
                            ['name' => $itemName],
                            [
                                'category' => $category,
                                'is_perishable' => true,
                                'current_stock' => 0,
                                'unit_cost' => $unitCost,
                                'min_stock' => 0,
                                'unit' => $unitType,
                            ]
                        );

                        $booking->inventoryItems()->attach($inventory->id, [
                            'quantity' => $quantity,
                            'quoted_unit_price' => $unitCost,
                            'is_ai_suggested' => 1,
                            'procurement_status' => 'pending',
                            'suggested_order_date' => $booking->suggested_procurement_date,
                        ]);
                    }

                    $booking->raw_materials_sum = $totalCost;
                    $booking->multiplier = 3.0;
                    $booking->final_quoted_price = $totalCost * 3.0;
                    $booking->total_quoted = $booking->final_quoted_price;
                    $booking->save();
                }
            }
        } catch (\Throwable $e) {
            Log::error('Guest Gemini Failure: ' . $e->getMessage());
            AiAnalysisResult::create([
                'booking_id' => $booking->id,
                'raw_gemini_response' => json_encode(['error' => $e->getMessage()]),
                'suggested_materials' => [],
                'analyzed_at' => Carbon::now(),
            ]);

            $booking->raw_materials_sum = 0;
            $booking->multiplier = 3.0;
            $booking->final_quoted_price = 0;
            $booking->total_quoted = 0;
            $booking->save();
        }

        return redirect()->route('guest.booking.analysis', ['booking' => $booking->id])
            ->with('success', 'Booking request created. Preparing your quotation now.');
    }

    /**
     * Display the guest booking analysis page.
     */
    public function analysis(Booking $booking): View
    {
        if ($booking->client_id !== null) {
            abort(403, 'This booking belongs to a registered client. Please log in.');
        }

        $analysis = $booking->aiAnalyses()->latest('analyzed_at')->first();
        $items = $booking->inventoryItems()->get();
        
        $analysisMaterials = [];
        if ($analysis && is_array($analysis->suggested_materials)) {
            $analysisMaterials = $analysis->suggested_materials;
        }

        $totalCost = $booking->final_quoted_price > 0 ? $booking->final_quoted_price : ($booking->total_quoted ?? 0);

        return view('guest.booking-analysis', [
            'booking' => $booking,
            'totalCost' => $totalCost,
            'analysis' => $analysis,
            'analysisMaterials' => $analysisMaterials,
            'items' => $items,
        ]);
    }
}
