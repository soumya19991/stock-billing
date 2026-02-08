@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="container-xl">

        <div class="page-header">
            <h2 class="page-title">Sales Invoices</h2>
        </div>

        <div class="card mt-3">
            <div class="table-responsive">
                <table class="table table-vcenter table-striped">
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>₹{{ number_format($invoice->total,2) }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.sales-invoices.show', $invoice->id) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($invoices->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No invoices found
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
