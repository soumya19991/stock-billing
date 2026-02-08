<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Purchase Return</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .header {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PURCHASE RETURN</h2>
        <p><strong>Return No:</strong> {{ $purchaseReturn->return_no }}</p>
    </div>

    <p>
        <strong>Vendor:</strong> {{ $purchaseReturn->purchase->vendor->name }} <br>
        <strong>Return Date:</strong> {{ $purchaseReturn->return_date }}
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchaseReturn->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td class="text-right">₹{{ number_format($item->cost_price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="text-right">
        Grand Total: ₹{{ number_format($purchaseReturn->total, 2) }}
    </h3>

    @if ($purchaseReturn->note)
        <p><strong>Note:</strong> {{ $purchaseReturn->note }}</p>
    @endif

</body>

</html>
