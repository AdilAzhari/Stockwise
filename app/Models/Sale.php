<?php

namespace App\Models;

use App\Observers\SaleObserver;
use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[observedBy([SaleObserver::class])]
class Sale extends Model
{
    /** @use HasFactory<SaleFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'user_id',
        'total_amount',
        'paid_amount',
        'status'
    ];

    /**
     * Get the customer that owns the sale.
     *
     * @return BelongsTo<Customer, Sale>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user (who created the sale) that owns the sale.
     *
     * @return BelongsTo<User, Sale>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sale products for the sale.
     *
     * @return HasMany<SaleProduct, Sale>
     */
    public function saleProducts(): HasMany
    {
        return $this->hasMany(SaleProduct::class);
    }

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    /**
     * Get the cashier (user) who handled the sale.
     *
     * @return BelongsTo<User, Sale>
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the activity log options for the model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('sale')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Sale was $eventName");
    }
}
