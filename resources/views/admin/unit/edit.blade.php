@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Unit</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Unit Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $unit->name) }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary">
                                Update Unit
                            </button>
                            <a href="{{ route('admin.units.index') }}"
                               class="btn btn-secondary">
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
