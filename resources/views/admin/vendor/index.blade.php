@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <div class="d-flex justify-content-between mb-3">
                    <h2 class="page-title">Vendors</h2>
                    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
                        Add Vendor
                    </a>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>GST</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendors as $vendor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td>{{ $vendor->phone }}</td>
                                            <td>{{ $vendor->gst_no }}</td>
                                            <td>
                                                <span class="badge {{ $vendor->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $vendor->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.vendors.edit', $vendor->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
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
    </div>
@endsection
