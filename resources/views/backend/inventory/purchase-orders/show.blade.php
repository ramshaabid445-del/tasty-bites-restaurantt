@extends('backend.layouts.app')
@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title d-flex justify-content-between align-items-center">
                    <h2 class="mb-0 fw-bold">PO Details: <span class="text-primary">{{ $order->po_number }}</span></h2>
                    <div class="btn-group">
                        <a href="{{ route('admin.inventory.purchase-orders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ti ti-arrow-left"></i> Back to List
                        </a>
                        <button onclick="window.print()" class="btn btn-primary btn-sm ms-2">
                            <i class="ti ti-printer"></i> Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="fw-bold mb-0">General Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold d-block">Supplier</label>
                    <span class="fs-5 fw-bold text-dark">{{ $order->supplier->name ?? 'N/A' }}</span>
                </div>
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold d-block">Order Date</label>
                    <span class="fs-6 fw-semibold">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</span>
                </div>
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold d-block">Status</label>
                    @php
                        $status = strtolower($order->status);
                        $badge = 'bg-light-warning text-warning';
                        if($status == 'received') $badge = 'bg-light-success text-success';
                        if($status == 'cancelled') $badge = 'bg-light-danger text-danger';
                    @endphp
                    <span class="badge {{ $badge }} border-0 px-3">{{ ucfirst($order->status) }}</span>
                </div>
                <hr class="opacity-50">
                <div class="mt-4">
                    <label class="text-muted small text-uppercase fw-bold d-block">Notes</label>
                    <p class="text-muted italic">{{ $order->notes ?? 'No special notes for this order.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Order Items</h5>
                <span class="text-muted small">{{ count($order->items ?? []) }} Items Total</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-muted small fw-bold border-0">Material Name</th>
                                <th class="text-muted small fw-bold text-center border-0">Quantity</th>
                                <th class="text-muted small fw-bold text-end border-0">Unit Price</th>
                                <th class="text-muted small fw-bold text-end border-0">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $item->material->name }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark">{{ $item->qty }}</span></td>
                                <td class="text-end text-muted">Rs. {{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-bold text-dark">Rs. {{ number_format($item->qty * $item->price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No items found in this order.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 p-4 rounded bg-primary-subtle d-flex justify-content-between align-items-center bg-light">
                    <h4 class="fw-bold mb-0 text-dark">Grand Total:</h4>
                    <h2 class="fw-bold mb-0 text-primary">Rs. {{ number_format($order->total_amount, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .page-header, .btn-group, .sidebar, .header { display: none !important; }
        .card { border: 1px solid #ddd !important; shadow: none !important; }
        .content-wrapper { margin: 0 !important; padding: 0 !important; }
    }
</style>
@endsection