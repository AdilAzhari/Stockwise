<?php

namespace App\Models;

use App\Observers\SaleProductObserver;
use Database\Factories\SaleProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy(SaleProductObserver::class)]
class SaleProduct extends Model
{
    /** @use HasFactory<SaleProductFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

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

    /**
     * Get the sale that owns the sale product.
     *
     * @return BelongsTo<Sale, SaleProduct>
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the product that owns the sale product.
     *
     * @return BelongsTo<Product, SaleProduct>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the activity log options for the model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('sale products')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Sale Product was $eventName");
    }
}
