@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            {{-- Page Header --}}
            <div class="page-header d-print-none mb-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Stock History
                        </h2>
                        <div class="text-muted mt-1">
                            Product: <strong>{{ $product->name }}</strong>
                            (SKU: {{ $product->sku }})
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.products.index') }}"
                           class="btn btn-secondary">
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>

            {{-- Stock Summary --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="subheader">Current Stock</div>
                            <div class="h1 mb-0">
                                {{ $product->stock->quantity ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stock History Table --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Stock Movements</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $key => $log)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>
                                    {{ $log->created_at->format('d M Y, h:i A') }}
                                </td>

                                <td>
                                    <span class="badge {{ $log->type == 'IN' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $log->type }}
                                    </span>
                                </td>

                                <td>
                                    {{ $log->quantity }}
                                </td>

                                <td>
                                    {{ $log->reference ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No stock movement found
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
