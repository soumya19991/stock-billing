@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Category</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name) }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary">Update Category</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
