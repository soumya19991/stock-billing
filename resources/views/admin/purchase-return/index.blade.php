@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <div class="d-flex justify-content-between mb-3">
                    <h2 class="page-title">Purchase Returns</h2>
                    <a href="{{ route('admin.purchase-returns.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Return
                    </a>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Return No</th>
                                    <th>Vendor</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($returns as $return)
                                    <tr>
                                        <td>{{ $return->return_no }}</td>
                                        <td>{{ $return->purchase->vendor->name }}</td>
                                        <td>{{ $return->return_date }}</td>
                                        <td>₹{{ number_format($return->total, 2) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.purchase-returns.show', $return) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No purchase returns found
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
