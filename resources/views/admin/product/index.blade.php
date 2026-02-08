{{-- @extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Products</h3>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary ms-auto">
                        Add Product
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th width="140">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>{{ $product->name }}</strong><br>
                                    <small class="text-muted">{{ $product->sku }}</small>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->unit->name }}</td>
                                <td>₹{{ number_format($product->price, 2) }}</td>

                                <td>
                                    @if($product->stock->quantity <= $product->alert_qty)
                                        <span class="badge bg-danger">
                                            {{ $product->stock->quantity }} (Low)
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            {{ $product->stock->quantity }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>

                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete product?')">Delete</button>
                                    </form>
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
@endsection --}}


@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            {{-- Page Header --}}
            <div class="page-header d-print-none mb-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Products</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.products.create') }}"
                           class="btn btn-primary">
                            Add Product
                        </a>
                    </div>
                </div>
            </div>

            {{-- Product Table --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product List</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Selling Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th width="200">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                {{-- Product --}}
                                <td>
                                    <strong>{{ $product->name }}</strong><br>
                                    <small class="text-muted">
                                        SKU: {{ $product->sku }}
                                    </small>
                                </td>

                                {{-- Category --}}
                                <td>{{ $product->category->name ?? '-' }}</td>

                                {{-- Unit --}}
                                <td>{{ $product->unit->name ?? '-' }}</td>

                                {{-- Price Management --}}
                                <td>
                                    ₹{{ number_format($product->latestPrice->selling_price ?? 0, 2) }}
                                </td>

                                {{-- Stock + Alert --}}
                                <td>
                                    @php
                                        $qty = $product->stock->quantity ?? 0;
                                    @endphp

                                    @if($qty <= $product->alert_qty)
                                        <span class="badge bg-danger">
                                            {{ $qty }} (Low)
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            {{ $qty }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if($product->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <a href="{{ route('admin.products.stock.history', $product->id) }}"
                                       class="btn btn-sm btn-info">
                                        Stock
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this product?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No products found
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

