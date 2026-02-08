@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">

        {{-- Page Header --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <h2 class="page-title">
                Invoice : {{ $invoice->invoice_no }}
            </h2>

            <div class="btn-list">
                {{-- PDF Button --}}
                <a href="{{ route('admin.sales-invoices.pdf', $invoice->id) }}"
                   target="_blank"
                   class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> Download PDF
                </a>

                {{-- Back --}}
                <a href="{{ route('admin.sales-invoices.index') }}"
                   class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Invoice Card --}}
        <div class="card mt-3">
            <div class="card-body">

                {{-- Invoice Info --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Customer</strong><br>
                        {{ $invoice->customer->name }}
                    </div>

                    <div class="col-md-4">
                        <strong>Invoice Date</strong><br>
                        {{ $invoice->invoice_date }}
                    </div>

                    <div class="col-md-4">
                        <strong>Status</strong><br>
                        <span class="badge bg-success">
                            {{ ucfirst($invoice->status) }}
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
                            @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>₹{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach

                            @if($invoice->items->isEmpty())
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
                        Total :
                        <span class="text-primary">
                            ₹{{ number_format($invoice->total, 2) }}
                        </span>
                    </h4>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
