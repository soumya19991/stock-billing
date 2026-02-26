@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                {{-- Header --}}
                <div class="d-flex justify-content-between mb-3">
                    <h2 class="page-title">Purchases (GRN)</h2>
                    <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">
                        Add Purchase
                    </a>
                </div>

                {{-- Table --}}
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>GRN No</th>
                                    <th>Vendor</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $purchase->purchase_no }}</td>
                                        <td>{{ $purchase->vendor->name }}</td>
                                        <td>{{ $purchase->purchase_date }}</td>
                                        <td>₹{{ number_format($purchase->total, 2) }}</td>
                                        <td>
                                            <span class="badge bg-success">Received</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No purchases found
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
    </div>
@endsection
