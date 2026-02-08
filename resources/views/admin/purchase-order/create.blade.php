@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <h2 class="page-title mb-3">Create Purchase Order</h2>

                <form action="{{ route('admin.purchase-orders.store') }}" method="POST">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Vendor</label>
                                    <select class="form-select" name="vendor_id" required>
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">PO Date</label>
                                    <input type="date" name="po_date" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Note</label>
                                    <input type="text" name="note" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">PO Items</h4>
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th width="120">Qty</th>
                                        <th width="150">Cost Price</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <button type="button" class="btn btn-outline-primary" onclick="addRow()">
                                Add Item
                            </button>

                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary">
                                Save PO
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let products = @json($products);
        let index = 0;

        function addRow() {
            let row = `
        <tr>
            <td>
                <select name="items[${index}][product_id]" class="form-select" required>
                    <option value="">Select</option>
                    ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="number" name="items[${index}][qty]" class="form-control" min="1" required>
            </td>
            <td>
                <input type="number" step="0.01" name="items[${index}][cost_price]" class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button>
            </td>
        </tr>`;
            document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);
            index++;
        }

        addRow();
    </script>
@endpush
