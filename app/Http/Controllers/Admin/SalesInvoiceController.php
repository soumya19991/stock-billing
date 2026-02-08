<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesInvoice;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\DB;

class SalesInvoiceController extends Controller
{
    //
    public function storeFromOrder(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'pending') {
            return back()->with('error', 'Order already invoiced');
        }

        DB::transaction(function () use ($salesOrder) {

            $subtotal = 0;

            foreach ($salesOrder->items as $item) {

                // 🔻 STOCK OUT
                \App\Services\StockService::decrease(
                    $item->product_id,
                    $item->quantity,
                    'Sales Invoice'
                );

                $subtotal += $item->subtotal;
            }

            $invoice = SalesInvoice::create([
                'sales_order_id' => $salesOrder->id,
                'customer_id' => $salesOrder->customer_id,
                'invoice_no' => 'INV-'.time(),
                'invoice_date' => now(),
                'subtotal' => $subtotal,
                'tax' => 0,
                'discount' => 0,
                'total' => $subtotal,
                'status' => 'paid',
            ]);

            foreach ($salesOrder->items as $item) {
                $invoice->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // ✅ Update SO status
            $salesOrder->update(['status' => 'completed']);
        });

        return redirect()
            ->route('admin.sales-orders.index')
            ->with('success', 'Sales Invoice created successfully');
    }

    public function index()
    {
        $invoices = SalesInvoice::with('customer')
            ->latest()
            ->get();

        return view('admin.sales-invoices.index', compact('invoices'));
    }

    public function show(SalesInvoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);

        return view('admin.sales-invoices.show', compact('invoice'));
    }

    public function pdf(SalesInvoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);

        $pdf = Pdf::loadView(
            'admin.sales-invoices.pdf',
            compact('invoice')
        );

        return $pdf->stream(
            'Invoice-'.$invoice->invoice_no.'.pdf'
        );
    }
}
