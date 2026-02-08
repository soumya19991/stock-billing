@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            {{-- Page Header --}}
            <div class="page-header d-print-none mb-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Add Vendor</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.vendors.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            {{-- Vendor Name --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vendor Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}">
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone') }}">
                            </div>

                            {{-- GST --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GST Number</label>
                                <input type="text"
                                       name="gst_no"
                                       class="form-control"
                                       value="{{ old('gst_no') }}">
                            </div>

                            {{-- Address --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address"
                                          class="form-control"
                                          rows="3">{{ old('address') }}</textarea>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                Save Vendor
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
