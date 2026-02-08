@extends('layout.admin.app')

@section('content')
<div class="page-wrapper">
<div class="page-body">
<div class="container-xl">

<h2 class="page-title mb-3">Create Purchase (GRN)</h2>

<form action="{{ route('admin.purchases.store') }}" method="POST">
@csrf

{{-- Vendor + Date --}}
<div class="card mb-3">
<div class="card-body">
<div class="row">

    <div class="col-md-4">
        <label class="form-label">Vendor</label>
        <select name="vendor_id" class="form-select" required>
            <option value="">Select Vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Purchase Date</label>
        <input type="date" name="purchase_date" class="form-control" required>
    </div>

</div>
</div>
</div>

{{-- Items --}}
<div class="card mb-3">
<div class="card-body p-0">
<table class="table table-bordered mb-0" id="items-table">
<thead>
<tr>
    <th>Product</th>
    <th width="120">Qty</th>
    <th width="150">Cost Price</th>
    <th width="150">Total</th>
    <th width="50"></th>
</tr>
</thead>
<tbody>
<tr>
    <td>
        <select name="products[0][product_id]" class="form-select product-select" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" name="products[0][qty]" class="form-control qty" value="1">
    </td>
    <td>
        <input type="number" name="products[0][cost_price]" class="form-control price" step="0.01">
    </td>
    <td>
        <input type="text" class="form-control total" readonly>
    </td>
    <td>
        <button type="button" class="btn btn-danger btn-sm remove-row">×</button>
    </td>
</tr>
</tbody>
</table>

<div class="p-3">
<button type="button" class="btn btn-secondary" id="add-row">
    + Add Item
</button>
</div>

</div>
</div>

{{-- Totals --}}
<div class="card">
<div class="card-body">
<div class="row">

    <div class="col-md-3">
        <label>Tax</label>
        <input type="number" name="tax" class="form-control" value="0">
    </div>

    <div class="col-md-3">
        <label>Discount</label>
        <input type="number" name="discount" class="form-control" value="0">
    </div>

    <div class="col-md-3">
        <label>Total</label>
        <input type="text" id="grand-total" class="form-control" readonly>
    </div>

</div>

<div class="text-end mt-3">
    <button class="btn btn-primary">Save Purchase</button>
</div>

</div>
</div>

</form>

</div>
</div>
</div>
@endsection

@push('js')
<script>
let rowIndex = 1;

document.getElementById('add-row').addEventListener('click', function () {
    let row = document.querySelector('#items-table tbody tr').cloneNode(true);

    row.querySelectorAll('input, select').forEach(el => el.value = '');
    row.querySelectorAll('input, select').forEach(el => {
        el.name = el.name.replace(/\[\d+\]/, '['+rowIndex+']');
    });

    document.querySelector('#items-table tbody').appendChild(row);
    rowIndex++;
});

document.addEventListener('input', function () {
    let grandTotal = 0;

    document.querySelectorAll('#items-table tbody tr').forEach(row => {
        let qty = row.querySelector('.qty').value || 0;
        let price = row.querySelector('.price').value || 0;
        let total = qty * price;

        row.querySelector('.total').value = total.toFixed(2);
        grandTotal += total;
    });

    document.getElementById('grand-total').value = grandTotal.toFixed(2);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-row')){
        e.target.closest('tr').remove();
    }
});
</script>
@endpush
