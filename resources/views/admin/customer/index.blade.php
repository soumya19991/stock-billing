@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <div class="d-flex justify-content-between mb-3">
                    <h2 class="page-title">Customers</h2>
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Customer
                    </a>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $customer->status ? 'success' : 'danger' }}">
                                                {{ $customer->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Edit
                                            </a>
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
@endsection
