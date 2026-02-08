@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <div class="card">
                    <div class="card-header">
                        <h3>Purchase Order {{ $purchaseOrder->po_no }}</h3>
                    </div>

                    <div class="card-body">
                        <p><strong>Vendor:</strong> {{ $purchaseOrder->vendor->name }}</p>
                        <p><strong>Date:</strong> {{ $purchaseOrder->po_date }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($purchaseOrder->status) }}</p>

                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Cost</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrder->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>₹{{ number_format($item->cost_price, 2) }}</td>
                                        <td>₹{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4 class="text-end">
                            Total: ₹{{ number_format($purchaseOrder->total, 2) }}
                        </h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
