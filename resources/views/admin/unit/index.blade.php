@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Units</h3>
                    <a href="{{ route('admin.units.create') }}" class="btn btn-primary ms-auto">
                        Add Unit
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Unit Name</th>
                                <th width="130">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $key => $unit)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $unit->name }}</td>
                                <td>
                                    <a href="{{ route('admin.units.edit', $unit->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.units.destroy', $unit->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this unit?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No units found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
