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
    ];
    public function added_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
