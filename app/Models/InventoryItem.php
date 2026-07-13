<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InventoryItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category',
        'is_perishable',
        'current_stock',
        'unit_cost',
        'min_stock',
        'unit',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_perishable' => 'boolean',
            'current_stock' => 'decimal:2',
            'unit_cost' => 'decimal:2',
            'min_stock' => 'decimal:2',
        ];
    }

    /**
     * Get all inventory transactions for this item.
     */
    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'inventory_item_id', 'id');
    }

    /**
     * Get all return items for this inventory item.
     */
    public function returnItems(): HasMany
    {
        return $this->hasMany(ReturnItem::class, 'inventory_item_id', 'id');
    }

    /**
     * Get all bookings that include this inventory item (through booking_items pivot).
     */
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(
            Booking::class,
            'booking_items',
            'inventory_item_id',
            'booking_id'
        )->withPivot(['quantity', 'quoted_unit_price', 'is_ai_suggested', 'procurement_status', 
                      'suggested_order_date', 'suggested_delivery_date', 'notes']);
    }

    /**
     * Get all returns that include this inventory item (through return_items pivot).
     */
    public function returns(): BelongsToMany
    {
        return $this->belongsToMany(
            AssetReturn::class,
            'return_items',
            'inventory_item_id',
            'return_id'
        )->withPivot(['quantity_returned', 'condition', 'final_amount', 'damage_charge', 'notes']);
    }

    /**
     * Check if inventory is low (below minimum stock).
     */
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->min_stock;
    }
}
