@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">

        <div class="page-header">
            <h2 class="page-title">Create Sales Order</h2>
        </div>

        <form action="{{ route('admin.sales-orders.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-body">

                    {{-- Customer & Date --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Order Date</label>
                            <input type="date" name="order_date" class="form-control" required>
                        </div>
                    </div>

                    <hr>

                    {{-- Products --}}
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th width="120">Qty</th>
                                <th width="150">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)

                                @php
                                    $reservedQty = \App\Models\SalesOrderItem::whereHas('salesOrder', function ($q) {
                                        $q->where('status', 'pending');
                                    })
                                    ->where('product_id', $product->id)
                                    ->sum('quantity');

                                    $availableQty = ($product->stock->quantity ?? 0) - $reservedQty;
                                @endphp

                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong>

                                        <small class="text-muted d-block">
                                            Stock: {{ $product->stock->quantity ?? 0 }}
                                        </small>

                                        <small class="text-muted d-block">
                                            Reserved: {{ $reservedQty }}
                                        </small>

                                        <small class="fw-bold d-block text-{{ $availableQty > 0 ? 'success' : 'danger' }}">
                                            Available: {{ max(0, $availableQty) }}
                                        </small>

                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            name="quantity[]"
                                            class="form-control"
                                            min="0"
                                            max="{{ max(0, $availableQty) }}"
                                            value="0"
                                            {{ $availableQty <= 0 ? 'disabled' : '' }}>
                                    </td>

                                    <td>
                                        <input
                                            type="number"
                                            name="price[]"
                                            class="form-control"
                                            value="{{ $product->latestPrice->selling_price ?? 0 }}"
                                            step="0.01"
                                            {{ $availableQty <= 0 ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                            @endforeach

                            @if($products->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No products available
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        Create Sales Order
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
