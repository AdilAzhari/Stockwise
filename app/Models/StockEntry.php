<?php

namespace App\Models;

use Database\Factories\StockEntryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class StockEntry extends Model
{
    /** @use HasFactory<StockEntryFactory> */
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'cost_price', 'added_by'];

    protected $casts = [
        'quantity' => 'integer',
        'cost_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($StockEntry) {
            if (Auth::check()) {
                $StockEntry->added_by = Auth::id();
            }
        });

        static::updating(function ($StockEntry) {
            if (Auth::check()) {
                $StockEntry->added_by = Auth::id();
            }
        });
    }
}
