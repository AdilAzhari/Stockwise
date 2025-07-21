<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'cost_price',
        'category_id',
        'supplier_id',
        'unit_price',
        'unit',
        'image_path',
        'barcode', 'buying_price', 'selling_price',
        'stock_quantity', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }
}
