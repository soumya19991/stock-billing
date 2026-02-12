@extends('layout.admin.app')

@section('content')

<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

```
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Product</h3>
            </div>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.products.store') }}">
                    @csrf

                    <div class="row">
                        {{-- Category --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Unit --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>
                            <select name="unit_id" class="form-select" required>
                                <option value="">Select</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Product Name --}}
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    {{-- SKU --}}
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control" required>
                    </div>

                    {{-- Price Section --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cost Price</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Selling Price</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Low Stock Alert Qty</label>
                            <input type="number" name="alert_qty" class="form-control" value="5">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            Save Product
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
