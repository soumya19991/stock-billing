<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Vendor;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * List all purchases (GRN)
     */
    public function index()
    {
        $purchases = Purchase::with('vendor')
            ->latest()
            ->get();

        return view('admin.purchase.index', compact('purchases'));
    }

    /**
     * Show create GRN form
     */
    public function create()
    {
        $vendors  = Vendor::where('status', 1)->get();
        $products = Product::where('status', 1)
            ->with('latestPrice')
            ->get();

        return view('admin.purchase.create', compact('vendors', 'products'));
    }

    /**
     * Store GRN and increase stock
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id'               => 'required|exists:vendors,id',
            'purchase_date'           => 'required|date',
            'products'                => 'required|array|min:1',
            'products.*.product_id'   => 'required|exists:products,id',
            'products.*.qty'          => 'required|integer|min:1',
            'products.*.cost_price'   => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            // Generate GRN Number
            $purchaseNo = 'GRN-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

            // Create Purchase (Master)
            $purchase = Purchase::create([
                'vendor_id'     => $request->vendor_id,
                'purchase_no'   => $purchaseNo,
                'purchase_date' => $request->purchase_date,
                'note'          => $request->note,
                'status'        => 1,
            ]);

            $subtotal = 0;

            // Loop through items
            foreach ($request->products as $item) {

                $lineTotal = $item['qty'] * $item['cost_price'];
                $subtotal += $lineTotal;

                // Save purchase item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $item['product_id'],
                    'qty'         => $item['qty'],
                    'cost_price'  => $item['cost_price'],
                    'total'       => $lineTotal,
                ]);

                // 🔥 INCREASE STOCK (ONLY PLACE WHERE STOCK IN HAPPENS)
                StockService::increase(
                    $item['product_id'],
                    $item['qty'],
                    'GRN #' . $purchaseNo
                );
            }

            // Update totals
            $purchase->update([
                'subtotal' => $subtotal,
                'tax'      => $request->tax ?? 0,
                'discount' => $request->discount ?? 0,
                'total'    => ($subtotal + ($request->tax ?? 0)) - ($request->discount ?? 0),
            ]);
        });

        return redirect()
            ->route('admin.purchases.index')
            ->with('success', 'Purchase (GRN) created and stock updated successfully');
    }
}