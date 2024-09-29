<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bill for Order #{{ $order->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .table th,
        .table td {
            padding: 12px;
            vertical-align: top;
        }

        .total {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
      
        <h2>Bill for Order #{{ $order->id }}</h2>

        <p><strong>Customer Name:</strong> {{ $order->customer->name }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        <h4>Order Details</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Item</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>SubTotal Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderProducts as $item)
                    <tr>
                        <td><img src="{{ public_path($item->product->images[0]->image_path) }}?height=100&width=100"
                                height="50px" width="50px" alt=""></td>
                        <td>{{ $item->product->title }}</td>
                        <td>NPR. {{ number_format($item->unitPrice, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>NPR.{{ $item->subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="text-right total">Net Amount: NPR.{{ number_format($order->nettotal, 2) }}</p>
        <p class="text-right total">Tax Amount: NPR.{{ number_format($order->taxAmount, 2) }}</p>
        <hr>
        <p class="text-right total">Grand Total Amount: NPR.{{ number_format($order->total_amount, 2) }}</p>

        <p>Thank you for your business!</p>
    </div>
</body>

</html>
