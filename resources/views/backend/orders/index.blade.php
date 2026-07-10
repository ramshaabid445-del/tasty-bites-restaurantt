@extends('backend.layouts.app')

{{-- 🔥 ADDED: Dynamic Browser Tab Title Wrapper --}}
@section('title', 'Sales Management - Order History')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-1 fw-bold text-dark">Order History</h2>
                </div>
                <ul class="breadcrumb small text-muted bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none"><i class="ti ti-home me-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item text-secondary">Sales Management</li>
                    <li class="breadcrumb-item active text-primary fw-semibold">Order History</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Session Flash Alert Notifications Handler Container --}}
@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
        <i class="ti ti-circle-check me-2 fs-5"></i> {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-0">
        <div>
            <h5 class="mb-0 fw-bold text-dark">All System Orders</h5>
            <small class="text-muted">Monitor and filter active food transactions</small>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <input type="text" class="form-control form-control-sm search-input" placeholder="Search order #..." style="border-radius: 8px; max-width: 200px;">
            <button class="btn btn-sm btn-light-secondary border" style="border-radius: 8px;"><i class="ti ti-filter"></i></button>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light-head">
                    <tr class="text-uppercase small text-muted">
                        <th class="ps-4 py-3" style="font-weight: 700;">Order #</th>
                        <th style="font-weight: 700;">Service Type</th>
                        <th style="font-weight: 700;">Customer Details</th>
                        <th style="font-weight: 700;">Amount</th>
                        <th style="font-weight: 700;">Status</th>
                        <th style="font-weight: 700;">Date & Time</th>
                        <th class="text-end pe-4" style="font-weight: 700;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="order-table-row">
                        <td class="ps-4">
                            <span class="fw-bold text-dark" style="font-size: 0.95rem;">#{{ $order->order_number }}</span>
                        </td>
                        <td>
                            @if(!empty($order->order_type))
                                <span class="badge rounded-pill border-0 px-3 py-2 text-uppercase fw-bold
                                    {{ strtolower($order->order_type) == 'dine_in' ? 'bg-light-info text-info' : '' }}
                                    {{ strtolower($order->order_type) == 'takeaway' ? 'bg-light-warning text-warning' : '' }}
                                    {{ strtolower($order->order_type) == 'delivery' ? 'bg-light-primary text-primary' : '' }}"
                                    style="font-size: 11px; letter-spacing: 0.3px;">
                                    {{ str_replace('_', ' ', $order->order_type) }}
                                </span>
                            @else
                                <span class="badge rounded-pill bg-light-secondary text-muted px-3 py-2 fw-bold" style="font-size: 11px;">NOT SPECIFIED</span>
                            @endif

                            @if($order->table)
                                <div class="mt-1 small text-dark fw-semibold ps-1">
                                    <i class="ti ti-armchair text-muted me-1"></i>{{ $order->table->name }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-dark">{{ $order->customer_name ?? 'Walk-in Guest' }}</span>
                                <small class="text-muted"><i class="ti ti-phone me-1 small"></i>{{ $order->customer_phone ?? 'No Contact' }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">Rs {{ number_format($order->total_amount, 0) }}</div>
                            <small class="text-muted text-uppercase small-payment" style="font-size: 9px;">{{ $order->payment_method ?? 'CASH' }}</small>
                        </td>
                        <td>
                            {{-- 🔥 FIX 2: Normalized Case-Insensitive String Checks For Loose Data Handling --}}
                            @php
                                $cleanStatus = strtolower(trim($order->status));
                            @endphp

                            @if($cleanStatus == 'pending' || $cleanStatus == '' || null)
                                <span class="badge bg-light-warning text-warning border-0 px-2.5 py-1.5 fw-bold"><i class="ti ti-clock me-1"></i>Pending</span>
                            @elseif($cleanStatus == 'processing' || $cleanStatus == 'cooking' || $cleanStatus == 'preparing')
                                <span class="badge bg-light-primary text-primary border-0 px-2.5 py-1.5 fw-bold"><i class="ti ti-chef-hat me-1"></i>Cooking</span>
                            @elseif($cleanStatus == 'completed' || $cleanStatus == 'complete' || $cleanStatus == 'success' || $cleanStatus == 'delivered' || $cleanStatus == 'served')
                                <span class="badge bg-light-success text-success border-0 px-2.5 py-1.5 fw-bold"><i class="ti ti-circle-check me-1"></i>Completed</span>
                            @elseif($cleanStatus == 'cancelled' || $cleanStatus == 'cancel' || $cleanStatus == 'rejected')
                                <span class="badge bg-light-danger text-danger border-0 px-2.5 py-1.5 fw-bold"><i class="ti ti-circle-x me-1"></i>Cancelled</span>
                            @else
                                {{-- Catch-all condition to display the exact database string state if it doesn't match above rules --}}
                                <span class="badge bg-light-secondary text-secondary border-0 px-2.5 py-1.5 text-uppercase fw-bold">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-dark fw-medium">{{ $order->created_at->format('d M Y') }}</span>
                                <small class="text-muted" style="font-size: 11px;"><i class="ti ti-clock-hour-4 me-1"></i>{{ $order->created_at->format('h:i A') }}</small>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm action-view-bill border-0 shadow-sm d-inline-flex align-items-center transition">
                                <i class="ti ti-receipt me-1.5 fs-5"></i> View Bill
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4 opacity-75">
                                <i class="ti ti-clipboard-list text-muted mb-2" style="font-size: 3.5rem; display: block;"></i>
                                <h6 class="text-muted fw-normal">No database logs found in history logs.</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Standard safe clean pagination footer markup implementation --}}
        @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
        <div class="px-4 py-3 border-top bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="small text-muted">Displaying {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }} records</span>
            <div>
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Table Styling Architecture Updates */
    .table-light-head { background-color: #f8f9fa; border-bottom: 1px solid #ebedef; }
    .order-table-row { transition: all 0.2s ease; }
    .order-table-row:hover { background-color: #f8f7ff !important; }
    
    /* View Details Button CSS context overrides */
    .action-view-bill {
        background-color: #fff !important;
        border: 1px solid #e3e8ef !important;
        color: #7267ef !important;
        font-weight: 600 !important;
        padding: 6px 14px !important;
        border-radius: 8px !important;
    }
    .action-view-bill:hover {
        background-color: #7267ef !important;
        color: #fff !important;
        border-color: #7267ef !important;
    }

    /* Custom Input Configurations */
    .search-input:focus {
        border-color: #7267ef !important;
        box-shadow: 0 0 0 0.2rem rgba(114, 103, 239, 0.15) !important;
    }

    /* System Light Badges Colors Standard overrides */
    .bg-light-info { background-color: #e0f2fe !important; }
    .bg-light-warning { background-color: #fef3c7 !important; }
    .bg-light-success { background-color: #d1fae5 !important; }
    .bg-light-primary { background-color: #e0e7ff !important; }
    .bg-light-danger { background-color: #fee2e2 !important; }
    .bg-light-secondary { background-color: #f3f4f6 !important; }
    
    /* Pagination Layout Correction rules */
    .pagination { margin-bottom: 0; }
    .page-link { border-radius: 6px !important; margin: 0 2px; border: 1px solid #e3e8ef; color: #4b5563; padding: 6px 12px; }
    .page-item.active .page-link { background-color: #7267ef !important; border-color: #7267ef !important; color: white !important; }
</style>
@endsection