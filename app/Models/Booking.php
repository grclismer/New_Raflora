<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'client_id',
        'handled_by',
        'event_type',
        'event_date',
        'event_size',
        'venue',
        'special_requests',
        'inspiration_image',
        'status',
        'downpayment_amount',
        'downpayment_date',
        'total_quoted',
        'price_valid_until',
        'suggested_procurement_date',
        'cancellation_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',
        'downpayment_date' => 'date',
        'price_valid_until' => 'date',
        'suggested_procurement_date' => 'date',
        'downpayment_amount' => 'decimal:2',
        'total_quoted' => 'decimal:2',
    ];

    /**
     * Get the client associated with this booking.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * Get the staff/admin user handling this booking.
     */
    public function handledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by', 'id');
    }

    /**
     * Get all quotations for this booking.
     */
    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'booking_id', 'id');
    }

    /**
     * Get the quotation history for this booking.
     */
    public function quotationHistory(): HasMany
    {
        return $this->hasMany(QuotationHistory::class, 'booking_id', 'id');
    }

    /**
     * Get all payments for this booking.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'booking_id', 'id');
    }

    /**
     * Get all returns for this booking.
     */
    public function returns(): HasMany
    {
        return $this->hasMany(AssetReturn::class, 'booking_id', 'id');
    }

    /**
     * Get all AI analysis results for this booking.
     */
    public function aiAnalyses(): HasMany
    {
        return $this->hasMany(AiAnalysisResult::class, 'booking_id', 'id');
    }

    /**
     * Get all meetings scheduled for this booking.
     */
    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'booking_id', 'id');
    }

    /**
     * Get all presentations for this booking.
     */
    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class, 'booking_id', 'id');
    }

    /**
     * Get all calendar events related to this booking.
     */
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'related_booking_id', 'id');
    }

    /**
     * Get all inventory transactions for this booking.
     */
    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'booking_id', 'id');
    }

    /**
     * Get all inventory items for this booking (through booking_items pivot).
     */
    public function inventoryItems(): BelongsToMany
    {
        return $this->belongsToMany(
            InventoryItem::class,
            'booking_items',
            'booking_id',
            'inventory_item_id'
        )->withPivot(['quantity', 'quoted_unit_price', 'is_ai_suggested', 'procurement_status', 
                      'suggested_order_date', 'suggested_delivery_date', 'notes']);
    }
}
