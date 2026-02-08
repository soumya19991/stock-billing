<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockLog;
use Exception;
use Illuminate\Support\Facades\DB;

class StockService
{
    public static function increase($productId, $qty, $reference = null)
    {
        DB::transaction(function () use ($productId, $qty, $reference) {

            $stock = Stock::firstOrCreate(
                ['product_id' => $productId],
                ['quantity' => 0]
            );

            $stock->increment('quantity', $qty);

            StockLog::create([
                'product_id' => $productId,
                'type' => 'IN',
                'quantity' => $qty,
                'reference' => $reference,
            ]);
        });
    }

    public static function decrease($productId, $qty, $reference = null)
    {
        DB::transaction(function () use ($productId, $qty, $reference) {

            $stock = Stock::where('product_id', $productId)->lockForUpdate()->first();

            if (! $stock || $stock->quantity < $qty) {
                throw new Exception('Insufficient stock');
            }

            $stock->decrement('quantity', $qty);

            StockLog::create([
                'product_id' => $productId,
                'type' => 'OUT',
                'quantity' => $qty,
                'reference' => $reference,
            ]);
        });
    }
}
