<?php

namespace App\Models;

use Database\Factories\SaleProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleProduct extends Model
{
    /** @use HasFactory<SaleProductFactory> */
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price_at_sale',
        'total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_at_sale' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
