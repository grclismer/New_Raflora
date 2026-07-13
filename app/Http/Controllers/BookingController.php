<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\AiAnalysisResult;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a list of bookings for the authenticated client.
     */
    public function index(): View
    {
        $client = $this->resolveClient();
        $bookings = Booking::where('client_id', $client?->id)->latest()->get();

        return view('client.bookings', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the booking creation form.
     */
    public function create(): View
    {
        return view('client.booking-create');
    }

    /**
     * Store a new booking.
     */
    public function store(BookingRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $client = $this->resolveClient();

        $inspirationImagePath = null;
        if ($request->hasFile('inspiration_image')) {
            $inspirationImagePath = $request->file('inspiration_image')->store('bookings/inspiration-images', 'public');
        }

        $totalQuoted = $this->estimateQuote($validated['event_type']);
        $priceValidUntil = Carbon::now()->addDays(7)->toDateString();
        $suggestedProcurement = Carbon::parse($validated['event_date'])->subDays(7)->toDateString();

        $booking = Booking::create([
            'client_id' => $client?->id,
            'handled_by' => null,
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'venue' => $validated['venue'],
            'special_requests' => $validated['special_requests'] ?? null,
            'inspiration_image' => $inspirationImagePath,
            'status' => 'quotation_sent',
            'total_quoted' => $totalQuoted,
            'price_valid_until' => $priceValidUntil,
            'suggested_procurement_date' => $suggestedProcurement,
        ]);

        AiAnalysisResult::create([
            'booking_id' => $booking->id,
            'raw_gemini_response' => json_encode(['simulated' => true, 'event_type' => $booking->event_type]),
            'suggested_materials' => $this->analysisMaterialsFor($booking->event_type),
            'analyzed_at' => Carbon::now(),
        ]);

        return redirect()->route('bookings.analysis', ['booking' => $booking->id])
            ->with('success', 'Booking request created. Preparing your quotation now.');
    }

    /**
     * Display the booking analysis page.
     */
    public function analysis(Booking $booking): View
    {
        $client = $this->resolveClient();

        if ($booking->client_id !== $client?->id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $analysis = $booking->aiAnalyses()->latest('analyzed_at')->first();
        $payment = $booking->payments()->latest()->first();

        return view('client.booking-analysis', [
            'booking' => $booking,
            'estimatedTotal' => $booking->total_quoted ?? $this->estimateQuote($booking->event_type),
            'analysis' => $analysis,
            'paymentStatus' => $payment?->status,
            'paymentReference' => $payment?->reference_number,
            'paymentMethod' => $payment?->payment_type,
        ]);
    }

    public function submitPaymentReference(Request $request, Booking $booking): RedirectResponse
    {
        $client = $this->resolveClient();

        if ($booking->client_id !== $client?->id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        if ($booking->status !== 'quotation_sent' && $booking->status !== 'payment_pending') {
            return back()->with('error', 'Payment reference cannot be submitted at this time.');
        }

        $validated = $request->validate([
            'reference_number' => ['required', 'string', 'max:255'],
            'payment_type' => ['required', 'string', 'in:gcash,bank_transfer'],
        ], [
            'reference_number.required' => 'Please provide your payment reference number.',
            'payment_type.required' => 'Please select a payment method.',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_quoted ?? 0,
            'payment_type' => $validated['payment_type'],
            'reference_number' => $validated['reference_number'],
            'status' => 'pending',
            'recorded_by' => null,
        ]);

        $booking->status = 'payment_pending';
        $booking->save();

        return back()->with('success', 'Payment reference submitted. Admin will verify your payment shortly.');
    }

    /**
     * Display the booking analysis page.
     */
    public function history(): View
    {
        $client = $this->resolveClient();
        $bookings = $client ? $client->bookings()->latest('created_at')->get() : collect();

        return view('client.booking-history', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Accept the quotation for a booking.
     */
    public function acceptQuotation(Booking $booking): RedirectResponse
    {
        $client = $this->resolveClient();

        if ($booking->client_id !== $client?->id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        if ($booking->status !== 'quotation_sent') {
            return back()->with('error', 'This booking cannot be accepted at this stage.');
        }

        $booking->status = 'downpayment_received';
        $booking->save();

        return redirect()->route('bookings')->with('success', 'Quotation accepted. Please complete your payment to confirm the booking.');
    }

    /**
     * Resolve the client record for the authenticated user.
     */
    protected function resolveClient(): ?Client
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        return Client::firstOrCreate(
            ['email' => $user->email],
            [
                'full_name' => $user->name,
                'phone' => $user->mobile_number,
                'address' => $user->address,
            ]
        );
    }

    protected function estimateQuote(string $eventType): float
    {
        return match ($eventType) {
            'wedding' => 45000.00,
            'corporate' => 28000.00,
            'birthday' => 18000.00,
            default => 20000.00,
        };
    }

    protected function analysisMaterialsFor(string $eventType): array
    {
        return match ($eventType) {
            'wedding' => [
                ['item_name' => 'White Roses', 'confidence' => 0.94, 'category' => 'flower', 'estimated_quantity' => 120, 'unit_cost' => 150.00],
                ['item_name' => 'Baby Breath', 'confidence' => 0.88, 'category' => 'flower', 'estimated_quantity' => 60, 'unit_cost' => 80.00],
                ['item_name' => 'Greenery Garlands', 'confidence' => 0.82, 'category' => 'foliage', 'estimated_quantity' => 20, 'unit_cost' => 220.00],
            ],
            'corporate' => [
                ['item_name' => 'Orchids', 'confidence' => 0.91, 'category' => 'flower', 'estimated_quantity' => 90, 'unit_cost' => 180.00],
                ['item_name' => 'Tropical Foliage', 'confidence' => 0.85, 'category' => 'foliage', 'estimated_quantity' => 70, 'unit_cost' => 110.00],
                ['item_name' => 'Black Calla Lilies', 'confidence' => 0.79, 'category' => 'flower', 'estimated_quantity' => 40, 'unit_cost' => 240.00],
            ],
            'birthday' => [
                ['item_name' => 'Pink Carnations', 'confidence' => 0.92, 'category' => 'flower', 'estimated_quantity' => 70, 'unit_cost' => 95.00],
                ['item_name' => 'Dried Pampas Grass', 'confidence' => 0.81, 'category' => 'foliage', 'estimated_quantity' => 30, 'unit_cost' => 140.00],
                ['item_name' => 'Ribbon Décor', 'confidence' => 0.75, 'category' => 'prop', 'estimated_quantity' => 15, 'unit_cost' => 180.00],
            ],
            default => [
                ['item_name' => 'Seasonal Blooms', 'confidence' => 0.78, 'category' => 'flower', 'estimated_quantity' => 80, 'unit_cost' => 110.00],
            ],
        };
    }
}
