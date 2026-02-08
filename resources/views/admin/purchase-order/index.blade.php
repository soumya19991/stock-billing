@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <div class="d-flex justify-content-between mb-3">
                    <h2 class="page-title">Purchase Orders</h2>
                    <a href="{{ route('admin.purchase-orders.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New PO
                    </a>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>PO No</th>
                                    <th>Vendor</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrders as $po)
                                    <tr>
                                        <td>{{ $po->po_no }}</td>
                                        <td>{{ $po->vendor->name }}</td>
                                        <td>{{ $po->po_date }}</td>
                                        <td>
                                            <span class="badge bg-{{ $po->status == 'approved' ? 'success' : 'warning' }}">
                                                {{ ucfirst($po->status) }}
                                            </span>
                                        </td>
                                        <td>₹{{ number_format($po->total, 2) }}</td>
                                        <td class="text-end">

                                            @if ($po->status == 'pending')
                                                <form action="{{ route('admin.purchase-orders.approve', $po->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($po->status == 'approved')
                                                <form action="{{ route('admin.purchase-orders.convert', $po->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-primary">
                                                        Convert
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
