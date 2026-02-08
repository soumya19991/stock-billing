@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">

        {{-- Page Header --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">
                    Sales Order : {{ $salesOrder->order_no }}
                </h2>
            </div>

            <div class="btn-list">
                <a href="{{ route('admin.sales-orders.index') }}"
                   class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>

                {{-- Convert to Invoice --}}
                @if($salesOrder->status === 'pending')
                <form action="{{ route('admin.sales-orders.convert-invoice', $salesOrder->id) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    <button type="submit"
                            class="btn btn-success"
                            onclick="return confirm('Convert this Sales Order to Invoice?')">
                        <i class="fa fa-file-invoice"></i> Convert to Invoice
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Order Info --}}
        <div class="card mt-3">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Customer:</strong><br>
                        {{ $salesOrder->customer->name }}
                    </div>

                    <div class="col-md-4">
                        <strong>Order Date:</strong><br>
                        {{ $salesOrder->order_date }}
                    </div>

                    <div class="col-md-4">
                        <strong>Status:</strong><br>
                        <span class="badge bg-{{ $salesOrder->status === 'pending' ? 'warning' : 'success' }}">
                            {{ ucfirst($salesOrder->status) }}
                        </span>
                    </div>
                </div>

                {{-- Items Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-vcenter">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th width="100">Qty</th>
                                <th width="150">Price</th>
                                <th width="150">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesOrder->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>₹{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach

                            @if($salesOrder->items->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No items found
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Total --}}
                <div class="text-end mt-3">
                    <h4>
                        Total Amount :
                        <span class="text-primary">
                            ₹{{ number_format($salesOrder->total_amount, 2) }}
                        </span>
                    </h4>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
