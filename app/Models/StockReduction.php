<?php

namespace App\Models;

use App\Observers\StockReductionObserver;
use Database\Factories\StockReductionFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy([StockReductionObserver::class])]
class StockReduction extends Model
{
    /** @use HasFactory<StockReductionFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'product_id',
        'quantity',
        'reason',
        'note',
        'user_id',
    ];

    /**
     * Get the user who added the stock reduction.
     *
     * @return BelongsTo<User, StockReduction>
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the stock reduction.
     *
     * @return BelongsTo<Product, StockReduction>
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
            ->useLogName('stock reduction')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "stock reduction was $eventName");
    }
}
