<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;
//    , SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    static function boot(): void
    {
        parent::boot();

        static::creating(function ($Category) {
            if (Auth::check()) {
                $Category->slug = str()->slug($Category->name);
            }
        });

        static::updating(function ($Category) {
            if (Auth::check()) {
                $Category->slug = str()->slug($Category->name);
            }
        });
    }
}
