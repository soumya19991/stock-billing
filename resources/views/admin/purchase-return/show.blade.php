@extends('layout.admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                <div class="card">

                    {{-- CARD HEADER --}}
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            Purchase Return : {{ $purchaseReturn->return_no }}
                        </h3>

                        <a href="{{ route('admin.purchase-returns.pdf', $purchaseReturn->id) }}" class="btn btn-sm btn-danger"
                            target="_blank">
                            <i class="fa fa-file-pdf"></i> Download PDF
                        </a>
                    </div>

                    {{-- CARD BODY --}}
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Vendor:</strong>
                                    {{ $purchaseReturn->purchase->vendor->name }}
                                </p>
                                <p><strong>Return Date:</strong>
                                    {{ $purchaseReturn->return_date }}
                                </p>
                            </div>

                            <div class="col-md-6 text-end">
                                <p><strong>Purchase Invoice:</strong>
                                    {{ $purchaseReturn->purchase->invoice_no ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-vcenter">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Rate</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseReturn->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-end">
                                                ₹{{ number_format($item->cost_price, 2) }}
                                            </td>
                                            <td class="text-end">
                                                ₹{{ number_format($item->total, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                @if ($purchaseReturn->note)
                                    <p><strong>Note:</strong> {{ $purchaseReturn->note }}</p>
                                @endif
                            </div>

                            <div class="col-md-6 text-end">
                                <h4>
                                    Grand Total :
                                    ₹{{ number_format($purchaseReturn->total, 2) }}
                                </h4>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
