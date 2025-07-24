<?php

namespace App\Models;

use Database\Factories\StockReductionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockReduction extends Model
{
    /** @use HasFactory<StockReductionFactory> */
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'reason',
        'note',
        'user_id'
    ];

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
        static::updating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
