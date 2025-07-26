<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /**
     * Handle the Category "creating" event.
     */
    public function creating(Category $category): void
    {
        if (Auth::check()) {
            $category->slug = str()->slug($category->name);
        }
    }

    /**
     * Handle the Category "updating" event.
     */
    public function updating(Category $category): void
    {
        if (Auth::check()) {
            $category->slug = str()->slug($category->name);
        }
    }
}
