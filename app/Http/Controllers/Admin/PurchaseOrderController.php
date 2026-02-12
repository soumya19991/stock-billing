<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Vendor;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * List PO
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('vendor')
            ->latest()
            ->get();

        return view('admin.purchase-order.index', compact('purchaseOrders'));
    }

    /**
     * Create PO form
     */
    public function create()
    {
        $vendors = Vendor::all();
        $products = Product::where('status', 1)->get();

        return view('admin.purchase-order.create', compact('vendors', 'products'));
    }

    /**
     * Store PO
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'po_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $po = PurchaseOrder::create([
                'po_no' => 'PO-'.time(),
                'vendor_id' => $request->vendor_id,
                'po_date' => $request->po_date,
                'note' => $request->note,
                'status' => 'pending',
                'total' => 0,
            ]);

            $grandTotal = 0;

            foreach ($request->items as $item) {
                if ($item['qty'] <= 0) {
                    continue;
                }

                $lineTotal = $item['qty'] * $item['cost_price'];

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'cost_price' => $item['cost_price'],
                    'total' => $lineTotal,
                ]);

                $grandTotal += $lineTotal;
            }

            $po->update(['total' => $grandTotal]);
        });

        return redirect()
            ->route('admin.purchase-orders.index')
            ->with('success', 'Purchase Order created successfully');
    }

    /**
     * Approve PO
     */
    public function approve(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'approved') {
            return back()->with('error', 'PO already approved');
        }

        $purchaseOrder->update(['status' => 'approved']);

        return back()->with('success', 'Purchase Order approved');
    }

    /**
     * Convert PO → Purchase (GRN)
     */
    public function convertToPurchase(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'approved') {
            return back()->with('error', 'PO must be approved first');
        }

        DB::transaction(function () use ($purchaseOrder) {

            $purchase = Purchase::create([
                'purchase_no' => 'PUR-'.date('Ymd').'-'.rand(1000, 9999),
                'vendor_id' => $purchaseOrder->vendor_id,
                'purchase_date' => now(),
                'total' => $purchaseOrder->total,
            ]);

            foreach ($purchaseOrder->items as $item) {

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'cost_price' => $item->cost_price,
                    'total' => $item->total,
                ]);

                StockService::increase(
                    $item->product_id,
                    $item->qty,
                    'PO Converted #'.$purchaseOrder->po_no
                );
            }
        });

        return redirect()
            ->route('admin.purchases.index')
            ->with('success', 'PO converted to Purchase successfully');
    }
}
