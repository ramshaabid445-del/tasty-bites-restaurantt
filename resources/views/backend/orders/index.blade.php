@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Order History</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li class="breadcrumb-item">Sales Management</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="card-header bg-white d-flex align-items-center justify-content-between">
        <h5 class="mb-0">All Completed Orders</h5>
        <div class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search order #">
            <button class="btn btn-sm btn-light-secondary"><i class="ti ti-filter"></i></button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Order #</th>
                        <th>Service Type</th>
                        <th>Customer Details</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-light-info text-info">
                                {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-600 text-dark">{{ $order->customer_name ?? 'Walk-in Guest' }}</span>
                                <small class="text-muted">{{ $order->customer_phone ?? 'No Contact' }}</small>
                            </div>
                        </td>
                        <td><span class="fw-bold text-dark">Rs {{ number_format($order->total_amount, 0) }}</span></td>
                        <td>
                            <span class="badge bg-light-success text-success">Completed</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-dark">{{ $order->created_at->format('d M Y') }}</span>
                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light-primary">
                                <i class="ti ti-receipt me-1"></i> View Bill
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <i class="ti ti-receipt fs-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-2">No orders found in history.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-4 py-3 border-top bg-light-faint">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
