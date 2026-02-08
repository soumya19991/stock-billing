@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <h2 class="page-title mb-3">Create Purchase Return</h2>

                <form action="{{ route('admin.purchase-returns.store') }}" method="POST">
                    @csrf

                    <div class="card mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Purchase</label>
                                    <select class="form-select" id="purchase_id" name="purchase_id" required>
                                        <option value="">Select Purchase</option>
                                        @foreach ($purchases as $purchase)
                                            <option value="{{ $purchase->id }}">
                                                {{ $purchase->invoice_no }} - {{ $purchase->vendor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Return Date</label>
                                    <input type="date" name="return_date" class="form-control" required>
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
                            <h4 class="card-title">Return Items</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-vcenter" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Purchased Qty</th>
                                        <th>Return Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Items loaded via JS --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-danger">
                                <i class="fa fa-undo"></i> Submit Return
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
        const purchases = @json($purchases);

        document.getElementById('purchase_id').addEventListener('change', function() {

            let purchaseId = this.value;
            let tbody = document.querySelector('#itemsTable tbody');
            tbody.innerHTML = '';

            let purchase = purchases.find(p => p.id == purchaseId);
            if (!purchase) return;

            purchase.items.forEach(item => {
                tbody.innerHTML += `
                <tr>
                    <td>${item.product.name}</td>
                    <td>${item.qty}</td>
                    <td>
                        <input type="number"
                               name="items[${item.product_id}][qty]"
                               class="form-control"
                               min="0"
                               max="${item.qty}">
                        <input type="hidden"
                               name="items[${item.product_id}][product_id]"
                               value="${item.product_id}">
                    </td>
                </tr>
            `;
            });
        });
    </script>
@endpush
