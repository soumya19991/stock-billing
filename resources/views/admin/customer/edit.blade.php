@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <h2 class="page-title mb-3">Edit Customer</h2>

                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ $customer->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">GST No</label>
                                <input type="text" name="gst_no" class="form-control" value="{{ $customer->gst_no }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $customer->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$customer->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
