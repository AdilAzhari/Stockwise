<?php

namespace App\Models;

use App\Observers\SupplierObserver;
use Database\Factories\SupplierFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy(SupplierObserver::class)]
class Supplier extends Model
{
    /** @use HasFactory<SupplierFactory> */
    use HasFactory, LogsActivity, softDeletes;

    protected $fillable = [
        'name',
        'contact_name',
        'address',
        'phone',
        'email',
        'slug',
        'payment_terms',
    ];

    /**
     * Get the products for the supplier.
     *
     * @return HasMany<Product, Supplier>
     */

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the activity log options for the model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('supplier')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Supplier was $eventName");
    }
}
