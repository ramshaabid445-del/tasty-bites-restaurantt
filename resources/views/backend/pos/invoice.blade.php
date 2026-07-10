<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - #{{ $order->order_number }}</title>
    <style>
        /* 🔥 FIX: Changed explicit 200mm height to auto for continuous roll thermal printing */
        @page { 
            size: 80mm auto; 
            margin: 0; 
        }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 13px; 
            line-height: 1.4; 
            color: #000; 
            margin: 0; 
            padding: 8px; 
            background-color: #fff;
        }
        .receipt { width: 100%; max-width: 280px; margin: auto; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; margin: 5px 0; }
        th { text-align: left; border-bottom: 1px solid #000; padding: 5px 0; font-size: 12px; font-weight: bold; }
        td { padding: 4px 0; vertical-align: top; }
        .brand-name { font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .order-info { font-size: 12px; margin-bottom: 10px; line-height: 1.5; }
        .total-section td { padding: 3px 0; }
        
        @media print {
            body { margin: 0; padding: 4px; background-color: #fff; }
            .no-print { display: none !important; }
            @page { margin: 0; } 
        }
    </style>
</head>
{{-- 🔥 PERFORMANCE WATCH: Auto call standard browser window print loop --}}
<body onload="window.print()">
    <div class="receipt">
        <div class="text-center">
            <h1 class="brand-name">MANTIS FOODS</h1>
            <p style="margin: 3px 0; font-size: 12px;">Fast Food Street, Sector G-10, Islamabad<br>
            <strong>Contact:</strong> +92 300 0000000</p>
        </div>

        <div class="divider"></div>

        <div class="order-info">
            <strong>ID:</strong> #{{ $order->order_number }} <br>
            <strong>Date:</strong> {{ $order->created_at->format('d/m/Y h:i A') }} <br>
            <strong>Type:</strong> {{ strtoupper(str_replace('_', ' ', $order->order_type)) }} 
            @if($order->table) | <strong>Table:</strong> {{ $order->table->name }} @endif <br>
            <strong>Cashier:</strong> {{ auth()->user()->name ?? 'Staff Counter' }}
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
                    {{-- 🔥 PATCH: Fallback validation logic protection for structural named fields --}}
                    <td>{{ $item->item_name ?? ($item->menuItem->name ?? 'Menu Item') }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">
                        {{-- 🔥 PATCH: Fallback for subtotal tracking calculations --}}
                        {{ number_format($item->sub_total ?? ($item->price * $item->quantity), 0) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <table class="total-section">
            <tr>
                <td>Sub-Total:</td>
                {{-- 🔥 PATCH: Fallback expression context checking --}}
                <td class="text-right">Rs {{ number_format($order->sub_total ?? ($order->total_amount - $order->tax_amount), 0) }}</td>
            </tr>
            <tr>
                <td>Tax ({{ $order->tax_percent ?? '5' }}%):</td>
                <td class="text-right">Rs {{ number_format($order->tax_amount, 0) }}</td>
            </tr>
            <tr class="fw-bold" style="font-size: 15px;">
                <td style="padding-top: 6px;">GRAND TOTAL:</td>
                <td class="text-right" style="padding-top: 6px;">Rs {{ number_format($order->total_amount, 0) }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="text-center" style="font-size: 11px; line-height: 1.6;">
            <p style="margin: 2px 0;">Customer: <strong>{{ $order->customer_name ?? 'Walk-in Guest' }}</strong></p>
            <p style="margin: 2px 0;">Payment Method: {{ strtoupper($order->payment_method ?? 'CASH') }}</p>
            <p style="margin-top: 12px; margin-bottom: 2px;">Software Powered by: <strong>Mantis Tech</strong></p>
            <p style="letter-spacing: 0.5px; font-weight: bold; margin-top: 4px;">--- THANK YOU & VISIT AGAIN ---</p>
        </div>

        {{-- Navigation bar controller bypass action utility --}}
        <div class="no-print text-center" style="margin-top: 25px; margin-bottom: 10px;">
            <a href="{{ route('admin.pos.index') }}" style="background: #7267ef; color: #fff; padding: 10px 24px; text-decoration: none; border-radius: 30px; font-family: sans-serif; font-size: 12px; font-weight: bold; display: inline-block; box-shadow: 0 4px 6px rgba(114, 103, 239, 0.2);">← Back to POS Screen</a>
        </div>
    </div>
</body>
</html>