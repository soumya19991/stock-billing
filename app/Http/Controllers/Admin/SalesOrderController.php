<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * List Sales Orders
     */
    public function index()
    {
        $orders = SalesOrder::with('customer')
            ->latest()
            ->get();

        return view('admin.sales-order.index', compact('orders'));
    }

    /**
     * Show Create SO Form
     */
    public function create()
    {
        $customers = Customer::where('status', 1)->get();
        $products = Product::with('stock', 'latestPrice')
            ->where('status', 1)
            ->get();

        return view('admin.sales-order.create', compact('customers', 'products'));
    }

    /**
     * Store Sales Order
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'product_id.*' => 'required|exists:products,id',
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',
        ]);

        // 🔒 RESERVE STOCK CHECK (ADD THIS PART)
        foreach ($request->product_id as $key => $productId) {

            $orderQty = $request->quantity[$key];

            $stock = Stock::where('product_id', $productId)->first();

            $reservedQty = $this->getReservedQty($productId);

            $availableQty = ($stock->quantity ?? 0) - $reservedQty;

            if ($orderQty > $availableQty) {
                return back()->withErrors([
                    'quantity' => 'Insufficient stock for selected product',
                ])->withInput();
            }
        }

        // ✅ IF PASSED → SAVE ORDER
        DB::transaction(function () use ($request) {

            $order = SalesOrder::create([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'order_no' => 'SO-'.time(),
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->product_id as $key => $productId) {

                $qty = $request->quantity[$key];
                $price = $request->price[$key];

                $subtotal = $qty * $price;
                $total += $subtotal;

                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_amount' => $total]);
        });

        return redirect()
            ->route('admin.sales-orders.index')
            ->with('success', 'Sales Order created successfully');
    }

    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load('customer', 'items.product');

        return view('admin.sales-order.show', compact('salesOrder'));
    }

    public function edit(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Only pending orders can be edited');
        }

        $salesOrder->load('items.product');

        return view('admin.sales-order.edit', compact('salesOrder'));
    }

    public function update(Request $request, SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Only pending orders can be updated');
        }

        $request->validate([
            'product_id.*' => 'required|exists:products,id',
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',
        ]);

        // 🔒 RESERVE STOCK CHECK (ADD THIS PART)
        foreach ($request->product_id as $key => $productId) {

            $orderQty = $request->quantity[$key];

            $stock = Stock::where('product_id', $productId)->first();

            $reservedQty = $this->getReservedQty($productId);

            // Remove current SO qty from reserved
            $currentQty = $salesOrder->items
                ->where('product_id', $productId)
                ->sum('quantity');

            $availableQty = ($stock->quantity ?? 0) - ($reservedQty - $currentQty);

            if ($orderQty > $availableQty) {
                return back()->withErrors([
                    'quantity' => 'Insufficient stock for selected product',
                ])->withInput();
            }
        }

        // ✅ AFTER validation → DB transaction
        DB::transaction(function () use ($request, $salesOrder) {

            $salesOrder->items()->delete();

            $total = 0;

            foreach ($request->product_id as $key => $productId) {

                $qty = $request->quantity[$key];
                $price = $request->price[$key];

                $subtotal = $qty * $price;
                $total += $subtotal;

                $salesOrder->items()->create([
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            $salesOrder->update([
                'total_amount' => $total,
            ]);
        });

        return redirect()
            ->route('admin.sales-orders.index')
            ->with('success', 'Sales Order updated successfully');
    }

    private function getReservedQty($productId)
    {
        return SalesOrderItem::where('product_id', $productId)
            ->whereHas('salesOrder', function ($q) {
                $q->where('status', 'pending');
            })
            ->sum('quantity');
    }
}
