<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        @page { size: 80mm 200mm; margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 13px; 
            line-height: 1.4; 
            color: #000; 
            margin: 0; 
            padding: 10px; 
        }
        .receipt { width: 100%; max-width: 280px; margin: auto; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; margin: 5px 0; }
        th { text-align: left; border-bottom: 1px solid #000; padding: 5px 0; font-size: 12px; }
        td { padding: 5px 0; vertical-align: top; }
        .brand-name { font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .order-info { font-size: 12px; margin-bottom: 10px; }
        .total-row td { padding-top: 5px; }
        @media print {
            .no-print { display: none; }
            body { padding: 5px; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <div class="text-center">
            <h1 class="brand-name">MANTIS FOODS</h1>
            <p style="margin: 3px 0;">Fast Food Street, Sector G-10, Islamabad<br>
            <strong>Contact:</strong> +92 300 0000000</p>
        </div>

        <div class="divider"></div>

        <div class="order-info">
            <strong>ID:</strong> #{{ $order->order_number }} <br>
            <strong>Date:</strong> {{ $order->created_at->format('d/m/Y h:i A') }} <br>
            <strong>Type:</strong> {{ strtoupper($order->order_type) }} 
            @if($order->table) | <strong>Table:</strong> {{ $order->table->name }} @endif <br>
            <strong>Cashier:</strong> {{ auth()->user()->name ?? 'Staff' }}
        </div>

        <div class="divider"></div>

        <table>
            <thead>
                <tr>
                    <th style="width: 55%;">ITEM</th>
                    <th class="text-center" style="width: 15%;">QTY</th>
                    <th class="text-right" style="width: 30%;">PRICE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->sub_total, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <table class="total-section">
            <tr>
                <td>Sub-Total:</td>
                <td class="text-right">Rs {{ number_format($order->sub_total, 0) }}</td>
            </tr>
            <tr>
                <td>Tax ({{ $order->tax_percent ?? '5' }}%):</td>
                <td class="text-right">Rs {{ number_format($order->tax_amount, 0) }}</td>
            </tr>
            <tr class="fw-bold" style="font-size: 15px;">
                <td>GRAND TOTAL:</td>
                <td class="text-right">Rs {{ number_format($order->total_amount, 0) }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="text-center" style="font-size: 11px;">
            <p>Customer: <strong>{{ $order->customer_name ?? 'Guest' }}</strong></p>
            <p>Payment: {{ strtoupper($order->payment_method) }}</p>
            <p style="margin-top: 10px;">Software by: <strong>Mantis Tech</strong></p>
            <p>--- THANK YOU & VISIT AGAIN ---</p>
        </div>

        <div class="no-print text-center" style="margin-top: 20px;">
            <a href="{{ route('admin.pos.index') }}" style="background: #7267ef; color: #fff; padding: 8px 20px; text-decoration: none; border-radius: 20px; font-family: sans-serif; font-size: 12px;">← Back to POS</a>
        </div>
    </div>
</body>
</html>