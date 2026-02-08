@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-xl">

            <h2>Create Sales Return</h2>

            <form method="POST" action="{{ route('admin.sales-returns.store') }}">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Sold Qty</th>
                            <th>Return Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    <input type="number" name="items[][quantity]" class="form-control"
                                        max="{{ $item->quantity }}" min="0">
                                    <input type="hidden" name="items[][product_id]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="items[][price]" value="{{ $item->price }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <textarea name="reason" class="form-control" placeholder="Reason"></textarea>

                <button class="btn btn-danger mt-3">
                    Process Return
                </button>

            </form>

        </div>
    </div>
@endsection
