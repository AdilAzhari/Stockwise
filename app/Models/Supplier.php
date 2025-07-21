<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_name',
        'address',
        'phone',
        'email',
        'payment_terms'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
