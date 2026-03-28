@extends('backend.layouts.app')

@section('content')
<div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card " id="invoiceCard">
                    <div class="card-body p-4 text-center">
                        <h2 class="fw-bold mb-1">FOOD POS</h2>
                        <p class="mb-0 text-muted small">Phase 5, DHA, Lahore</p>
                        <p class="mb-3 text-muted small">Ph: 0300-0000000</p>
                        
                        <div style="border-top: 1px dashed #ccc;" class="my-3"></div>
                        
                        <div class="d-flex justify-content-between text-start small mb-1">
                            <span>Order No: <strong>{{ $order->order_number }}</strong></span>
                            <span>Date: {{ $order->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-start small mb-3">
                            <span>Type: {{ ucfirst($order->order_type) }}</span>
                            @if($order->table)
                                <span>Table: {{ $order->table->name }}</span>
                            @endif
                        </div>

                        <table class="table table-sm text-start mb-3 small">
                            <thead>
                                <tr class="border-bottom">
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div style="border-top: 1px dashed #ccc;" class="my-3"></div>

                        <div class="d-flex justify-content-between small mb-1">
                            <span>Sub Total:</span>
                            <span>Rs {{ number_format($order->sub_total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Tax (GST 5%):</span>
                            <span>Rs {{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                            <span>NET TOTAL:</span>
                            <span>Rs {{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        <div style="border-top: 1px dashed #ccc;" class="my-3"></div>
                        <p class="small mb-0 italic">Software by: MyFirstProject</p>
                        <p class="small fw-bold mt-2">*** THANK YOU ***</p>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 no-print">
                    <a href="{{ route('admin.orders.history') }}" class="btn btn-secondary w-100">Back</a>
                    <button onclick="window.print()" class="btn btn-primary w-100">
                        <i class="ti ti-printer me-1"></i> Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .pc-sidebar, .pc-header, .no-print, .pc-footer, .page-header {
        display: none !important;
    }
    .pc-container {
        margin: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection