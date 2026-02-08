<?php

namespace App\Http\Controllers\Admin;

use App\Models\SalesInvoice;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Services\StockService;
use DB;

class SalesReturnController extends Controller
{
    public function create(SalesInvoice $invoice)
    {
        return view('admin.sales-returns.create', compact('invoice'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $return = SalesReturn::create([
                'sales_invoice_id' => $request->invoice_id,
                'return_date' => now(),
                'reason' => $request->reason,
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {

                if ($item['quantity'] == 0) {
                    continue;
                }

                $subtotal = $item['quantity'] * $item['price'];
                $total += $subtotal;

                SalesReturnItem::create([
                    'sales_return_id' => $return->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                // 🔥 STOCK IN
                StockService::increase(
                    $item['product_id'],
                    $item['quantity'],
                    'SR-'.$return->id
                );
            }

            $return->update(['total_amount' => $total]);
        });

        return redirect()
            ->route('admin.sales-returns.index')
            ->with('success', 'Sales Return processed successfully');
    }
}
