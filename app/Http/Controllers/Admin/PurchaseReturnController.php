<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseReturnController extends Controller
{
    /**
     * Show purchase return list
     */
    public function index()
    {
        $returns = PurchaseReturn::with('purchase.vendor')
            ->latest()
            ->get();

        return view('admin.purchase-return.index', compact('returns'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $purchases = Purchase::with(['vendor', 'items.product'])
            ->latest()
            ->get();

        return view('admin.purchase-return.create', compact('purchases'));
    }

    /**
     * Store purchase return
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'return_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            // Create return master
            $return = PurchaseReturn::create([
                'purchase_id' => $request->purchase_id,
                'return_no' => 'PR-' . time(),
                'return_date' => $request->return_date,
                'total' => 0,
                'note' => $request->note,
            ]);

            $grandTotal = 0;

            foreach ($request->items as $item) {

                if ($item['qty'] <= 0) {
                    continue;
                }

                $purchaseItem = DB::table('purchase_items')
                    ->where('purchase_id', $request->purchase_id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                // Safety check
                if (!$purchaseItem || $item['qty'] > $purchaseItem->qty) {
                    throw new \Exception('Invalid return quantity');
                }

                $lineTotal = $item['qty'] * $purchaseItem->cost_price;

                PurchaseReturnItem::create([
                    'purchase_return_id' => $return->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'cost_price' => $purchaseItem->cost_price,
                    'total' => $lineTotal,
                ]);

                // 🔥 STOCK DECREASE
                StockService::decrease(
                    $item['product_id'],
                    $item['qty'],
                    'Purchase Return #' . $return->return_no
                );

                $grandTotal += $lineTotal;
            }

            // Update return total
            $return->update(['total' => $grandTotal]);
        });

        return redirect()
            ->route('admin.purchase-returns.index')
            ->with('success', 'Purchase return created successfully');
    }

    /**
     * Show return details (PDF later)
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->load('items.product', 'purchase.vendor');

        return view('admin.purchase-return.show', compact('purchaseReturn'));
    }
    public function pdf(PurchaseReturn $purchaseReturn)
{
    $purchaseReturn->load('items.product', 'purchase.vendor');

    $pdf = Pdf::loadView(
        'admin.purchase-return.pdf',
        compact('purchaseReturn')
    );

    return $pdf->download(
        $purchaseReturn->return_no . '.pdf'
    );
}
}