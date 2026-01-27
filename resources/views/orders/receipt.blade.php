{{-- resources/views/orders/receipt.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            font-family: 'Courier New', monospace;
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>{{ $order->barbershop->name }}</h2>
        <p>{{ $order->barbershop->address }}</p>
        <p>{{ $order->barbershop->phone }}</p>
    </div>

    <div class="divider"></div>

    <p>
        <strong>Order #:</strong> {{ $order->order_number }}<br>
        <strong>Date:</strong> {{ $order->order_date->format('d/m/Y H:i') }}<br>
        <strong>Cashier:</strong> {{ $order->creator->name }}
    </p>

    <div class="divider"></div>

    <table>
        @foreach ($order->items as $item)
            <tr>
                <td colspan="2">{{ $item->item_name }}</td>
            </tr>
            <tr>
                <td>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
        </tr>
        @if ($order->discount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr class="total">
            <td>TOTAL:</td>
            <td class="text-right">Rp {{ number_format($order->final_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Payment:</td>
            <td class="text-right">{{ $order->payment_method->label() }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <p style="text-align: center;">
        Thank you for your visit!<br>
        <small>{{ now()->format('d/m/Y H:i:s') }}</small>
    </p>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Print Receipt</button>
        <button onclick="window.close()">Close</button>
    </div>
</body>

</html>
