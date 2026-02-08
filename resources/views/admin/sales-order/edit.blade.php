@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-xl">

            <h2>Edit Sales Order {{ $salesOrder->order_no }}</h2>

            <form method="POST" action="{{ route('admin.sales-orders.update', $salesOrder) }}">
                @csrf
                @method('PUT')

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th width="120">Qty</th>
                            <th width="150">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesOrder->items as $item)
                            <tr>
                                <td>
                                    {{ $item->product->name }}
                                    <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control"
                                        value="{{ $item->quantity }}">
                                </td>
                                <td>
                                    <input type="number" name="price[]" class="form-control" value="{{ $item->price }}"
                                        step="0.01">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-primary">Update Sales Order</button>
            </form>

        </div>
    </div>
@endsection
