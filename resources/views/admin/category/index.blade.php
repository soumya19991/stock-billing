@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary ms-auto">
                        Add Category
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $key => $category)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
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
</div>
@endsection
