@extends('backend.layouts.app')

{{-- Browser tab title configuration wrapper --}}
@section('title', 'Order History')

@section('content')
<div class="container-fluid p-0">
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="fw-bold text-dark mb-1">Order History</h2>
                <p class="text-muted mb-0">Manage and track all restaurant orders</p>
            </div>
            <a href="{{ route('admin.pos.index') }}" class="btn btn-primary d-flex align-items-center shadow-sm" style="border-radius: 10px; padding: 10px 20px; background-color: #7267ef; border: none;">
                <i class="ti ti-plus me-2 fs-5"></i> New POS Order
            </a>
        </div>
    </div>

    {{-- 🔥 ADDED: Dynamic Flash Status Session handling alert banner container --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 10px;">
            <i class="ti ti-circle-check me-2 fs-4"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 10px;">
            <i class="ti ti-alert-circle me-2 fs-4"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; border-bottom: 1px solid #ebedef;">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4 py-3" style="font-weight: 700; width: 18%;">Order Info</th>
                            <th style="font-weight: 700; width: 22%;">Customer</th>
                            <th style="font-weight: 700; width: 18%;">Type & Table</th>
                            <th style="font-weight: 700; width: 15%;">Amount</th>
                            <th style="font-weight: 700; width: 15%;">Status</th>
                            <th class="text-end pe-4" style="font-weight: 700; width: 12%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="order-row">
                            <td class="ps-4">
                                <div class="fw-bold text-dark" style="font-size: 0.95rem;">#{{ $order->order_number }}</div>
                                <small class="text-muted"><i class="ti ti-calendar-event me-1"></i>{{ $order->created_at->format('d M Y, h:i A') }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $order->customer_name ?? 'Walk-in Guest' }}</div>
                                <small class="text-muted text-truncate" style="max-width: 150px; display: block;">
                                    <i class="ti ti-phone me-1"></i>{{ $order->customer_phone ?? 'No Phone' }}
                                </small>
                            </td>
                            <td>
                                <span class="badge {{ $order->order_type == 'dine_in' ? 'bg-light-info text-info' : 'bg-light-warning text-warning' }} border-0 px-3 py-2" style="font-size: 10px; letter-spacing: 0.5px;">
                                    {{ strtoupper(str_replace('_', ' ', $order->order_type)) }}
                                </span>
                                @if($order->table)
                                    <div class="mt-1 small text-primary fw-bold d-flex align-items-center">
                                        <i class="ti ti-armchair me-1"></i> {{ $order->table->name }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">Rs {{ number_format($order->total_amount, 0) }}</div>
                                <small class="badge bg-light-success text-success border-0 px-2" style="font-size: 9px;">
                                    {{ strtoupper($order->payment_method ?? 'CASH') }}
                                </small>
                            </td>
                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" id="status-form-{{ $order->id }}">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm status-select
                                        {{ $order->status == 'pending' ? 'text-warning' : ($order->status == 'completed' ? 'text-success' : ($order->status == 'processing' ? 'text-primary' : 'text-danger')) }}"
                                        onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>👨‍🍳 Cooking</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.pos.invoice', $order->id) }}" target="_blank" class="action-btn btn-print" title="Print Invoice">
                                        <i class="ti ti-printer fs-5"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn btn-view" title="View Details">
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="ti ti-clipboard-list text-muted opacity-25" style="font-size: 4rem;"></i>
                                    <h6 class="mt-3 text-muted fw-normal">No orders found in the system.</h6>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 🔥 OPTIMIZED: Clean dynamic Laravel structural checking loops for Pagination controls --}}
        @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
        <div class="card-footer bg-white border-0 py-3 border-top">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                <span class="small text-muted">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders</span>
                <div>
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Table Rows Interactivity */
    .order-row { transition: background 0.2s ease; }
    .order-row:hover { background-color: #f8f7ff !important; }

    /* Custom Form Dropdowns */
    .status-select {
        border: 1px solid #e3e8ef !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        padding: 6px 12px !important;
        background-color: #fff !important;
        cursor: pointer;
        width: 135px;
        box-shadow: none !important;
        font-size: 13px;
    }
    .status-select:focus { border-color: #7267ef !important; }

    /* Grid Functional Action Buttons UI context styles */
    .action-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
        background: #fff;
        border: 1px solid #e3e8ef;
    }

    .btn-print { color: #7267ef; }
    .btn-print:hover { background: #7267ef; color: #fff; border-color: #7267ef; }

    .btn-view { color: #4b5563; }
    .btn-view:hover { background: #f1f5f9; color: #000; border-color: #cbd5e0; }

    /* Custom Light Badges context layout */
    .bg-light-info { background-color: #e0f2fe !important; }
    .bg-light-warning { background-color: #fef3c7 !important; }
    .bg-light-success { background-color: #d1fae5 !important; }

    /* Global Overrides for clean custom navigation buttons layout styling */
    .pagination { margin-bottom: 0; }
    .page-link { border-radius: 6px; margin: 0 2px; border: 1px solid #e3e8ef; color: #4b5563; }
    .page-link:hover { background-color: #f1f5f9; color: #7267ef; }
    .page-item.active .page-link { background-color: #7267ef !important; border-color: #7267ef !important; color: white !important; }
</style>
@endsection