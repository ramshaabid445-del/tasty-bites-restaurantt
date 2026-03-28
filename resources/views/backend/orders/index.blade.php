@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h5 class="mb-2">Order History</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">All Orders</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Order #</th>
                                <th>Type</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $order->order_number }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-light-info text-info">
                                        {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $order->customer_name ?? 'Walk-in' }}</span>
                                        <small class="text-muted">{{ $order->customer_phone ?? 'N/A' }}</small>
                                    </div>
                                </td>
                                <td class="fw-bold">Rs {{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-success">Completed</span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-receipt me-1"></i> View Bill
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection