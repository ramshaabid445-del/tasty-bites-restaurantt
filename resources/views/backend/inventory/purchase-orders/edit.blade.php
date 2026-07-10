@extends('backend.layouts.app')
@section('content')
<div class="container-fluid py-4">
    <form action="{{ route('admin.inventory.purchase-orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="total_amount" id="total_amount_input" value="{{ $order->total_amount }}">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Edit Purchase Order</h3>
            <button type="submit" class="btn btn-primary px-4 shadow">Update Order</button>
        </div>

        <div class="row g-4 d-flex align-items-stretch">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">PO NUMBER</label>
                            <input type="text" class="form-control bg-light fw-bold" value="{{ $order->po_number }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">SUPPLIER</label>
                            <select name="supplier_id" class="form-select" required>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}" {{ $order->supplier_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">STATUS</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="received" {{ $order->status == 'received' ? 'selected' : '' }}>Received</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Update Items</h5>
                        <div class="alert alert-info small">Note: Editing items functionality requires an items table relationship.</div>
                        <h2 class="text-end fw-bold text-primary mt-4">Total: Rs. <span id="grand-total-display">{{ number_format($order->total_amount, 2) }}</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection