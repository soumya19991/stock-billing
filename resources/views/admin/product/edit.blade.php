@extends('layout.admin.app')

@section('content')

<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Product</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Category & Unit --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>
                            <select name="unit_id" class="form-select" required>
                                <option value="">Select Unit</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Product Name --}}
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $product->name) }}"
                               required>
                    </div>

                    {{-- SKU --}}
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $product->sku }}"
                               readonly>
                        <small class="text-muted">
                            SKU cannot be changed
                        </small>
                    </div>

                    {{-- Cost & Selling Price --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cost Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="cost_price"
                                   class="form-control"
                                   value="{{ old('cost_price', $product->latestPrice->cost_price ?? 0) }}"
                                   required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Selling Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="selling_price"
                                   class="form-control"
                                   value="{{ old('selling_price', $product->latestPrice->selling_price ?? 0) }}"
                                   required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Low Stock Alert Qty</label>
                            <input type="number"
                                   name="alert_qty"
                                   class="form-control"
                                   value="{{ old('alert_qty', $product->alert_qty) }}">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4">
                        <button class="btn btn-primary">
                            Update Product
                        </button>

                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>
```

</div>
@endsection
