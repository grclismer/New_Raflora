<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnItem extends Model
{
    /**
     * Table name override.
     */
    protected $table = 'return_items';

    /**
     * Indicates if the model has timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'return_id',
        'inventory_item_id',
        'quantity_returned',
        'condition',
        'final_amount',
        'damage_charge',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity_returned' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'damage_charge' => 'decimal:2',
        ];
    }

    /**
     * Get the return associated with this return item.
     */
    public function assetReturn(): BelongsTo
    {
        return $this->belongsTo(AssetReturn::class, 'return_id', 'id');
    }

    /**
     * Get the inventory item for this return item.
     */
    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id', 'id');
    }
}
