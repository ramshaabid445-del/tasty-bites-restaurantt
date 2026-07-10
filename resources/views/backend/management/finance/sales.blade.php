@extends('backend.layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container-fluid p-0">
    {{-- 1. Page Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-12">
            <h4 class="fw-bold text-dark mb-1">Sales Overview</h4>
            <p class="text-muted small mb-0">Monitor your daily transactions and revenue</p>
        </div>
    </div>

    {{-- 2. Stats Widgets --}}
    <div class="row g-4 mb-4 d-flex align-items-stretch">
        {{-- Total Revenue Card --}}
        <div class="col-md-4">
            <div class="h-100 sales-hover-card-primary" style="background: linear-gradient(135deg, #7267ef 0%, #9e8cf1 100%) !important; 
                        border-radius: 16px !important; 
                        padding: 1.5rem !important; 
                        position: relative !important; 
                        overflow: hidden !important;
                        box-shadow: 0 4px 12px rgba(114, 103, 239, 0.15) !important;
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                
                <i class="ti ti-chart-bar widget-bg-icon" style="position: absolute !important; right: -10px !important; bottom: -10px !important; font-size: 80px !important; color: white !important; opacity: 0.15 !important; transition: all 0.3s ease;"></i>
                
                <div style="position: relative !important; z-index: 2 !important;">
                    <p style="color: rgba(255,255,255,0.8) !important; margin-bottom: 5px !important; font-size: 0.9rem !important; font-weight: 500 !important;">Total Revenue</p>
                    <h2 style="color: white !important; font-weight: 800 !important; margin-bottom: 0 !important; font-size: 1.8rem;">
                        {{ number_format($total_sales ?? 0, 2) }} <small style="font-size: 0.8rem !important; opacity: 0.7 !important;">PKR</small>
                    </h2>
                </div>
            </div>
        </div>

        {{-- Total Orders Card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 sales-hover-card" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Total Orders</p>
                            <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.8rem;">{{ $sales->total() ?? 0 }}</h2>
                        </div>
                        <div class="bg-light-primary p-3 rounded-circle text-primary widget-circle-icon" style="transition: all 0.3s ease;">
                            <i class="ti ti-shopping-cart fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average Order Value Card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 sales-hover-card" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Average Order Value</p>
                            <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.8rem;">
                                {{ number_format(($total_sales ?? 0) / max(($sales->total() ?? 1), 1), 2) }}
                            </h2>
                        </div>
                        <div class="bg-light-success p-3 rounded-circle text-success widget-circle-icon" style="transition: all 0.3s ease;">
                            <i class="ti ti-cash fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Sales Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="fw-bold text-dark mb-0">Recent Transactions</h5>
            {{-- 🔥 FIXED SAFELY: No route generation to prevent routing exceptions, completely safe click action --}}
            <a href="javascript:void(0);" onclick="alert('Export functionality coming soon!')" class="btn btn-light-secondary btn-sm rounded-pill px-3 fw-bold btn-custom-hover">
                <i class="ti ti-download me-1"></i> Export CSV
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bold">ORDER ID</th>
                            <th class="border-0 text-muted small fw-bold">CUSTOMER</th>
                            <th class="text-center border-0 text-muted small fw-bold">AMOUNT</th>
                            <th class="text-center border-0 text-muted small fw-bold">STATUS</th>
                            <th class="text-end pe-4 border-0 text-muted small fw-bold">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales ?? [] as $sale)
                        <tr class="table-row-hover" style="transition: background-color 0.2s ease;">
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-dark">#{{ $sale->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light-info text-info rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 35px; height: 35px; font-size: 12px;">
                                        {{ strtoupper(substr($sale->customer_name ?? 'G', 0, 1)) }}
                                    </div>
                                    <span class="fw-medium text-dark">{{ $sale->customer_name ?? 'Guest Customer' }}</span>
                                </div>
                            </td>
                            <td class="text-center fw-bold text-primary">
                                {{ number_format($sale->total_amount, 2) }}
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light-success text-success px-3 py-2 fw-bold" style="font-size: 10px;">
                                    <i class="ti ti-circle-check me-1"></i> PAID
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                {{-- 🔥 FIXED SAFELY: Retained previous layout style structure with zero-exception dead link --}}
                                <a href="javascript:void(0);" class="btn btn-sm btn-light-primary rounded-circle p-2 btn-action-hover d-inline-flex align-items-center justify-content-center" style="width:34px; height:34px; transition: all 0.2s ease;" title="View Details">
                                    <i class="ti ti-file-text fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <p class="text-muted mb-0">No sales records found for this period.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-0 pt-0 pb-4 d-flex justify-content-center">
            {{ $sales->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    .bg-light-subtle { background-color: #fcfcfd; }
    .bg-light-primary { background: rgba(114, 103, 239, 0.1); color: #7267ef; }
    .bg-light-success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .bg-light-info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .btn-light-secondary { background: #f3f4f9; color: #5b6b79; border: none; }
    .btn-light-primary { background: #eeecfd; color: #7267ef; border: none; }
    .table thead th { border-bottom: 1px solid #f0f0f0 !important; }
    .h-100 { min-height: 100% !important; }

    /* Premium Hover States (Sizes Unaffected) */
    .sales-hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.06) !important;
    }
    .sales-hover-card:hover .widget-circle-icon {
        transform: scale(1.08);
    }
    .sales-hover-card-primary:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(114, 103, 239, 0.3) !important;
    }
    .sales-hover-card-primary:hover .widget-bg-icon {
        transform: scale(1.15) rotate(-5deg);
    }
    .btn-custom-hover {
        transition: all 0.2s ease !important;
    }
    .btn-custom-hover:hover {
        background: #e4e6f1 !important;
        color: #1e293b !important;
    }
    .btn-custom-hover:active, .btn-action-hover:active {
        transform: scale(0.96);
    }
    .table-row-hover:hover {
        background-color: #fcfcfd !important;
    }
    .btn-action-hover:hover {
        background: #7267ef !important;
        color: white !important;
    }
</style>
@endsection