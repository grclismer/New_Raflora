<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Mail\BookingStatusChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $bookings = Booking::with('client')
            ->when($status && $status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('admin.bookings', [
            'bookings' => $bookings,
            'statusFilter' => $status ?? 'all',
        ]);
    }

    public function show(Booking $booking): View
    {
        $booking->load(['client', 'aiAnalyses', 'payments']);
        $analysis = $booking->aiAnalyses()->latest('analyzed_at')->first();
        $payment = $booking->payments()->latest()->first();

        return view('admin.booking-show', [
            'booking' => $booking,
            'analysis' => $analysis,
            'payment' => $payment,
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'event_type' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'venue' => ['required', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:pending,quotation_sent,payment_pending,downpayment_received,completed,declined,cancelled'],
            'special_requests' => ['nullable', 'string', 'max:2000'],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking->event_type = $data['event_type'];
        $booking->event_date = $data['event_date'];
        $booking->venue = $data['venue'];
        $booking->status = $data['status'];
        $booking->special_requests = $data['special_requests'] ?? $booking->special_requests;
        $booking->handled_by = Auth::id();


        // Process admin note
        $adminNote = $data['admin_note'] ?? '';

        // Process item adjustments if provided and append to admin note
        $items = $request->input('items', []);
        if (!empty($items) && is_array($items)) {
            $lines = [];
            foreach ($items as $it) {
                $name = $it['item_name'] ?? 'Item';
                $qty = isset($it['adjusted_quantity']) ? (int)$it['adjusted_quantity'] : null;
                $unavailable = !empty($it['unavailable']) ? 'Yes' : 'No';
                $lines[] = "$name — Qty: " . ($qty !== null ? $qty : 'n/a') . " — Unavailable: $unavailable";
            }
            $itemsSummary = "\nItem adjustments:\n" . implode("\n", $lines);
            $adminNote = trim(($adminNote ? $adminNote . "\n\n" : '') . $itemsSummary);
        }

        if (!empty($adminNote)) {
            $booking->cancellation_reason = $adminNote;
        }

        // Handle action buttons
        $action = $request->input('action', 'save');
        $notificationStatus = null;

        if ($action === 'send_quotation') {
            $booking->status = 'quotation_sent';
            $notificationStatus = 'quotation_sent';
        } elseif ($action === 'accept') {
            // Accept booking and move to payment pending by default
            $booking->status = 'payment_pending';
            $notificationStatus = 'payment_pending';
        } elseif ($data['status'] === 'declined' && $booking->wasChanged('status')) {
            $notificationStatus = 'declined';
        }

        $booking->save();

        if ($notificationStatus && $booking->client && filter_var($booking->client->email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($booking->client->email)->send(new BookingStatusChanged($booking, null, $notificationStatus));
            } catch (\Throwable $e) {
                // If mail fails, still keep the booking update.
                logger()->error('Booking status notification failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.bookings.show', ['booking' => $booking->id])
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Verify a payment submitted by a client.
     */
    public function verifyPayment(Request $request, Payment $payment): RedirectResponse
    {
        $payment->status = 'verified';
        $payment->recorded_by = Auth::id();
        $payment->save();

        $booking = $payment->booking;
        if ($booking) {
            $booking->status = 'downpayment_received';
            $booking->save();
            // send notification to client
            try {
                if ($booking->client && filter_var($booking->client->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($booking->client->email)
                        ->send(new BookingStatusChanged($booking, $payment, 'downpayment_received'));
                }
            } catch (\Throwable $e) {
                // do not break the flow on mail errors; log if necessary
                // logger()->error('Mail send failed: '.$e->getMessage());
            }
        }

        return back()->with('success', 'Payment verified and booking updated.');
    }

    /**
     * Decline a booking request.
     */
    public function decline(Request $request, Booking $booking): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking->status = 'declined';
        if (!empty($data['admin_note'])) {
            $booking->cancellation_reason = $data['admin_note'];
        }
        $booking->handled_by = Auth::id();
        $booking->save();

        // notify client
        try {
            if ($booking->client && filter_var($booking->client->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($booking->client->email)
                    ->send(new BookingStatusChanged($booking, null, 'declined'));
            }
        } catch (\Throwable $e) {
            // logger()->error('Mail send failed: '.$e->getMessage());
        }

        return redirect()->route('admin.bookings')->with('success', 'Booking declined.');
    }
}
