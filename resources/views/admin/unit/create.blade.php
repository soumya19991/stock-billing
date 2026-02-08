@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Unit</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.units.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Unit Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Ex: pcs, kg, box"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary">
                                Save Unit
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
