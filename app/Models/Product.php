<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, LogsActivity, SoftDeletes;

    protected static bool $logOnlyDirty = true;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'cost_price',
        'category_id',
        'supplier_id',
        'unit_price',
        'alert_quantity',
        'unit',
        'image_path',
        'barcode', 'buying_price', 'selling_price',
        'stock_quantity', 'is_active', 'slug',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'unit_price' => 'float',
        'cost_price' => 'float',
        'buying_price' => 'float',
        'selling_price' => 'float',
        'stock_quantity' => 'integer',
        'unit' => 'string',
    ];

    /**
     * Get the Category who added the stock entry.
     *
     * @return BelongsTo<Product, Category>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the stock entries for the product.
     *
     * @return HasMany<StockEntry, Product>
     */
    public function stockEntries(): HasMany
    {
        return $this->hasMany(StockEntry::class);
    }

    /**
     * Get the sale products for the product.
     *
     * @return HasMany<SaleProduct, Product>
     */
    public function saleProducts(): HasMany
    {
        return $this->hasMany(SaleProduct::class);
    }
    /**
     * Get the supplier that owns the stock entry.
     *
     * @return BelongsTo<Supplier, Product>
     */

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the stock reductions for the product.
     *
     * @return HasMany<StockReduction, Product>
     */
    public function stockReductions(): HasMany
    {
        return $this->hasMany(StockReduction::class);
    }

    /**
     * Get the activity log options for the model.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the User that owns the Product.
     *
     * @return BelongsTo<User, Product>
     */

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
