<?php

namespace App\Models;

use App\Observers\StockEntryObserver;
use Database\Factories\StockEntryFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy([StockEntryObserver::class])]
class StockEntry extends Model
{
    /** @use HasFactory<StockEntryFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = ['product_id', 'quantity', 'cost_price', 'added_by', 'reference_number'];

    protected $casts = [
        'quantity' => 'integer',
        'cost_price' => 'decimal:2',
    ];

    /**
     * Get the product that owns the stock entry.
     *
     * @return BelongsTo<Product, StockEntry>
     */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    /**
     * Get the user who added the stock entry.
     *
     * @return BelongsTo<User, StockEntry>
     */

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get the activity log options for the model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('stock entry')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Stock Entry was $eventName");
    }
}
