@extends('backend.layouts.app')

@section('title', 'Daily Sales Report')

@section('content')
<div class="container-fluid p-0">
    {{-- 1. Header Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h4 class="fw-bold text-dark mb-1">Daily Sales Report (EOD)</h4>
            <p class="text-muted small mb-0">End of day summary and transaction breakdown</p>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-2 shadow-sm border">
                <i class="ti ti-calendar-event me-2 text-primary"></i>
                <span class="fw-bold text-dark small">{{ date('d M, Y') }}</span>
            </div>
            <button class="btn btn-primary shadow-sm rounded-2 ms-2 px-4 fw-bold" onclick="window.print()">
                <i class="ti ti-printer me-1"></i> Print Report
            </button>
        </div>
    </div>

    {{-- 2. Stats Summary Widgets --}}
    <div class="row g-4 mb-4 d-flex align-items-stretch">
        {{-- Total Revenue Card (Purple) --}}
        <div class="col-xl-4 col-md-6">
            <div style="background: linear-gradient(135deg, #7267ef 0%, #9e8cf1 100%) !important; 
                        border-radius: 12px !important; 
                        padding: 1.5rem !important; 
                        position: relative !important; 
                        overflow: hidden !important;
                        height: 100% !important;
                        display: flex !important;
                        flex-direction: column !important;
                        justify-content: center !important;
                        box-shadow: 0 4px 12px rgba(114, 103, 239, 0.15) !important;">
                
                <i class="ti ti-chart-arrows-vertical" style="position: absolute !important; right: -10px !important; bottom: -10px !important; font-size: 80px !important; color: white !important; opacity: 0.15 !important;"></i>
                
                <div style="position: relative !important; z-index: 2 !important;">
                    <p style="color: rgba(255,255,255,0.8) !important; margin-bottom: 5px !important; font-size: 0.85rem !important; font-weight: 600 !important; text-transform: uppercase; letter-spacing: 0.5px;">Total Gross Revenue</p>
                    <h2 style="color: white !important; font-weight: 800 !important; margin-bottom: 0 !important; font-size: 1.8rem;">
                        Rs. {{ number_format($total_revenue, 2) }}
                    </h2>
                </div>
            </div>
        </div>
        
        {{-- Total Orders Card --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-light-success p-3 rounded-3 text-success me-3">
                        <i class="ti ti-shopping-cart fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Total Orders</p>
                        {{-- 🔥 PATCH: Replaced count() with total() to prevent layout data clipping during shifts --}}
                        <h3 class="fw-bold mb-0 text-dark">{{ $orders->total() ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Avg Ticket Size Card --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-light-info p-3 rounded-3 text-info me-3">
                        <i class="ti ti-receipt-2 fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Avg. Ticket Size</p>
                        <h3 class="fw-bold mb-0 text-dark">
                            {{-- 🔥 PATCH: Average value calculated securely using total records set --}}
                            Rs. {{ ($orders->total() ?? 0) > 0 ? number_format($total_revenue / $orders->total(), 2) : '0.00' }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Orders Table --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-transparent border-0 p-4 border-bottom">
            <h5 class="fw-bold text-dark mb-0">Transaction Breakdown</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bold">ORDER ID</th>
                            <th class="border-0 text-muted small fw-bold">TIMESTAMP</th>
                            <th class="border-0 text-muted small fw-bold text-center">PAYMENT TYPE</th>
                            <th class="text-end pe-4 border-0 text-muted small fw-bold">TOTAL AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $order)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-primary">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium">{{ $order->created_at->format('h:i A') }}</span>
                                    <small class="text-muted x-small">Today</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-2 {{ strtolower($order->payment_method) == 'cash' ? 'bg-light-success text-success' : 'bg-light-info text-info' }} px-3 py-2 border-0 fw-bold" style="font-size: 10px;">
                                    {{ strtoupper($order->payment_method) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="fw-bold text-dark">Rs. {{ number_format($order->total_amount, 2) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-25 mb-3 text-muted">
                                    <i class="ti ti-mood-empty fs-1"></i>
                                </div>
                                <p class="text-muted">No sales recorded for today yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- 🔥 ADDED: Centered Bootstrap-5 Pagination Control for shifting page grids without dropping date logic --}}
        <div class="card-footer bg-transparent border-0 pt-0 pb-4 d-flex justify-content-center d-print-none">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    /* UI Clean Up */
    .bg-light-subtle { background-color: #fcfcfd; }
    .bg-light-success { background: rgba(40, 199, 111, 0.1); color: #28c76f; }
    .bg-light-info { background: rgba(0, 207, 232, 0.1); color: #00cfe8; }
    
    .table thead th { 
        border-bottom: 1px solid #f0f0f0 !important; 
        font-size: 11px; 
        letter-spacing: 0.8px;
        color: #8c9097 !important;
    }
    
    .table tbody tr { border-bottom: 1px solid #f8f9fa; }
    .table tbody tr:hover { background-color: #fbfbff; }
    .x-small { font-size: 10px; }

    /* Button Square Styles */
    .btn-primary { background-color: #7267ef !important; border-color: #7267ef !important; }

    @media print {
        .btn, .sidebar, .header-navbar, .breadcrumb, .d-print-none { display: none !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        body { background: white !important; }
    }
</style>
@endsection