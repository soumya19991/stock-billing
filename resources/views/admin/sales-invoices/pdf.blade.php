<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_no }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-box {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>SALES INVOICE</h2>
    </div>

    <table class="invoice-box">
        <tr>
            <td class="no-border">
                <strong>Invoice No:</strong> {{ $invoice->invoice_no }}<br>
                <strong>Date:</strong> {{ $invoice->invoice_date }}
            </td>
            <td class="no-border text-right">
                <strong>Customer:</strong><br>
                {{ $invoice->customer->name }}
            </td>
        </tr>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <table>
        <tr>
            <td class="text-right"><strong>Subtotal</strong></td>
            <td class="text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Tax</strong></td>
            <td class="text-right">₹{{ number_format($invoice->tax, 2) }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Discount</strong></td>
            <td class="text-right">₹{{ number_format($invoice->discount, 2) }}</td>
        </tr>
        <tr>
            <td class="text-right"><strong>Total</strong></td>
            <td class="text-right"><strong>₹{{ number_format($invoice->total, 2) }}</strong></td>
        </tr>
    </table>

    <br><br>

    <p>
        <strong>Status:</strong> {{ ucfirst($invoice->status) }}
    </p>

</body>

</html>
