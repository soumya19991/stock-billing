@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
    <div class="container-xl">

        <div class="d-flex justify-content-between mb-3">
            <h2 class="page-title">Sales Orders</h2>
            <a href="{{ route('admin.sales-orders.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> New Sales Order
            </a>
        </div>

        <div class="card mt-3">
            <div class="table-responsive">
                <table class="table table-vcenter table-striped">
                    <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <!-- View -->
                                    <a href="{{ route('admin.sales-orders.show', $order->id) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <!-- Edit (Only Pending) -->
                                    @if ($order->status === 'pending')
                                        <a href="{{ route('admin.sales-orders.edit', $order->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No sales orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>
</div>
@endsection
