<?php

namespace App\Exports;

use App\Models\StockMovement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockMovementExport implements FromCollection
{
    public function collection(): Collection
    {
        return StockMovement::with('product')->get()->map(function ($movement) {
            return [
                'Product' => $movement->product->name,
                'Type' => $movement->type,
                'Quantity' => $movement->quantity,
                'Date' => $movement->created_at->format('Y-m-d H:i'),
            ];
        });
    }
}
