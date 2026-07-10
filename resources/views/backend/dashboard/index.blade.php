@extends('backend.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid p-4 dashboard-container">

    {{-- PAGE HEADER --}}
    <div class="row align-items-center mb-4">
        <div class="col-12">
            <h2 class="fw-extrabold m-0 tracking-tight" style="color: #1e293b; font-size: 1.75rem;">Restaurant Dashboard</h2>
            <p class="text-muted small mb-0">Real-time statistics and business overview</p>
        </div>
    </div>

    {{-- TOP STATS --}}
    <div class="row g-3 mb-4">
        {{-- Revenue --}}
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card custom-card stat-card h-100 shadow-sm border-0">
                <div class="card-body p-3 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="stat-title text-muted mb-0 fw-semibold">Today's Revenue</h6>
                        <div class="icon-box bg-light-success text-success animate-icon">
                            <i class="ti ti-currency-dollar"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">Rs {{ number_format($todayRevenue, 0) }}</h3>
                    <div class="card-decoration-bg bg-success"></div>
                    <div class="stat-accent-bar bg-success"></div>
                </div>
            </div>
        </div>

        {{-- Occupancy --}}
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card custom-card stat-card h-100 shadow-sm border-0">
                <div class="card-body p-3 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="stat-title text-muted mb-0 fw-semibold">Occupancy</h6>
                        <div class="icon-box bg-light-info text-info animate-icon">
                            <i class="ti ti-armchair"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $activeTables }} / {{ $totalTables }}</h3>
                    <small class="text-muted fw-medium d-block">{{ $totalTables - $activeTables }} tables free</small>
                    <div class="card-decoration-bg bg-info"></div>
                    <div class="stat-accent-bar bg-info"></div>
                </div>
            </div>
        </div>

        {{-- Orders --}}
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card custom-card stat-card h-100 shadow-sm border-0">
                <div class="card-body p-3 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="stat-title text-muted mb-0 fw-semibold">Today's Orders</h6>
                        <div class="icon-box bg-light-warning text-warning animate-icon">
                            <i class="ti ti-shopping-cart"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $todayOrders }}</h3>
                    <div class="card-decoration-bg bg-warning"></div>
                    <div class="stat-accent-bar bg-warning"></div>
                </div>
            </div>
        </div>

        {{-- Popular Item --}}
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card custom-card stat-card h-100 shadow-sm border-0">
                <div class="card-body p-3 position-relative overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="stat-title text-muted mb-0 fw-semibold">Popular Item</h6>
                        <div class="icon-box bg-light-danger text-danger animate-icon">
                            <i class="ti ti-flame"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1 text-truncate text-dark" style="max-width: 100%;">{{ $topItem->item_name ?? 'No Sales' }}</h5>
                    <small class="text-muted fw-medium">{{ $topItem->total_qty ?? 0 }} sold</small>
                    <div class="card-decoration-bg bg-danger"></div>
                    <div class="stat-accent-bar bg-danger"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECOND ROW - Chart & Financial --}}
    <div class="row g-4 mb-4 equal-height-row">
        <div class="col-xl-8 col-lg-7">
            <div class="card custom-card panel-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0" style="color: #1e293b;">Weekly Sales Overview</h5>
                        <p class="text-muted small mb-0">Monitor store sales trends effortlessly</p>
                    </div>
                    <span class="chart-badge">
                        <i class="ti ti-trending-up"></i> Live
                    </span>
                </div>
                <div class="card-body p-3 d-flex flex-column justify-content-center">
                    <div id="sales-chart" style="width: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card custom-card panel-card border-0 shadow-sm financial-card">
                <div class="card-header bg-transparent border-0 py-3 px-4">
                    <h5 class="fw-bold mb-0" style="color: #1e293b;">Financial Summary</h5>
                    <p class="text-muted small mb-0">Projected metrics for the active week</p>
                </div>
                <div class="card-body d-flex flex-column px-4 pb-4 pt-2">
                    <p class="text-muted mb-1 fw-semibold small tracking-wide text-uppercase">Weekly Estimate</p>
                    <h2 class="fw-extrabold mb-4 modern-gradient-text">
                        Rs {{ number_format($todayRevenue * 5.2, 0) }}
                    </h2>

                    <div class="financial-list flex-grow-1 d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 financial-item">
                            <span class="fw-semibold text-secondary"><i class="ti ti-trending-up text-success me-2"></i>Net Profit</span>
                            <span class="badge bg-soft-success text-success fw-bold px-3 py-2 rounded-pill">65%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 financial-item">
                            <span class="fw-semibold text-secondary"><i class="ti ti-receipt text-warning me-2"></i>Calculated Tax</span>
                            <span class="badge bg-soft-secondary text-secondary fw-bold px-3 py-2 rounded-pill">5%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 financial-item">
                            <span class="fw-semibold text-secondary"><i class="ti ti-shield-check text-info me-2"></i>Current Risk</span>
                            <span class="badge bg-soft-success text-success fw-bold px-3 py-2 rounded-pill">Low</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="row">
        <div class="col-12">
            <div class="card custom-card panel-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3 px-4">
                    <div>
                        <h5 class="fw-bold mb-0" style="color: #1e293b;">Recent Orders</h5>
                        <p class="text-muted small mb-0">Latest customer activities and receipts</p>
                    </div>
                    <a href="{{ route('admin.orders.history') }}" class="btn btn-sm px-4 rounded-pill btn-modern-primary shadow-sm text-white fw-semibold">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-modern mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Type</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr class="modern-row">
                                <td class="ps-4 fw-bold text-dark">#{{ $order->order_number }}</td>
                                <td><span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold text-uppercase small-badge">{{ ucfirst($order->order_type) }}</span></td>
                                <td class="text-muted fw-medium">{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($order->payment_status == 'paid')
                                        <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill fw-bold d-inline-flex align-items-center gap-1"><span class="dot-indicator bg-success"></span>Paid</span>
                                    @else
                                        <span class="badge bg-soft-warning text-warning px-3 py-2 rounded-pill fw-bold d-inline-flex align-items-center gap-1"><span class="dot-indicator bg-warning"></span>Pending</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 fw-extrabold text-dark" style="font-size: 1.05rem;">Rs {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted fw-medium">No recent orders found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Layout & Variables */
.dashboard-container { 
    background: #f8fafc; 
    min-height: 100vh; 
    font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
}
.fw-extrabold { font-weight: 800; }

/* Page header accent */
.dashboard-container h2.fw-extrabold {
    position: relative;
    padding-left: 14px;
}
.dashboard-container h2.fw-extrabold::before {
    content: '';
    position: absolute;
    left: 0;
    top: 4px;
    bottom: 4px;
    width: 5px;
    border-radius: 6px;
    background: linear-gradient(180deg, #7267ef 0%, #4a3aff 100%);
}

/* Premium Cards Styling */
.custom-card { 
    border-radius: 16px !important; 
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #ffffff;
}
.stat-card {
    border: 1px solid rgba(226, 232, 240, 0.6) !important;
    overflow: hidden;
}
.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 28px -8px rgba(114, 103, 239, 0.18), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
    border-color: rgba(114, 103, 239, 0.25) !important;
}
.panel-card {
    border: 1px solid rgba(226, 232, 240, 0.8) !important;
}
.panel-card:hover {
    box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.06) !important;
}

/* Top accent bar that reveals on hover for stat cards */
.stat-accent-bar {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    opacity: 0;
    transform: scaleX(0.4);
    transform-origin: left;
    transition: all 0.35s ease;
    border-radius: 16px 16px 0 0;
}
.stat-card:hover .stat-accent-bar {
    opacity: 1;
    transform: scaleX(1);
}

/* Micro Background Decoration on Hover */
.card-decoration-bg {
    position: absolute;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    bottom: -35px;
    right: -35px;
    opacity: 0;
    filter: blur(22px);
    transition: all 0.4s ease;
    z-index: 1;
}
.stat-card:hover .card-decoration-bg {
    opacity: 0.12;
    transform: scale(1.5);
}
.stat-card .card-body { z-index: 2; position: relative; }

/* FIX: Equal Height Alignment for Row */
.equal-height-row { display: flex; flex-wrap: wrap; }
.equal-height-row > [class*='col-'] { display: flex; flex-direction: column; }
.equal-height-row .card { flex: 1; height: 100%; margin-bottom: 0; }

/* Advanced Icon Box Interactions */
.icon-box {
    width: 46px; height: 46px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px; font-size: 1.4rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
.stat-card:hover .animate-icon {
    transform: scale(1.12) rotate(6deg);
    box-shadow: 0 6px 14px rgba(0,0,0,0.08);
}

/* Typography Enhancements */
.stat-title { font-size: 0.85rem; letter-spacing: 0.025em; color: #64748b !important; }
.modern-gradient-text {
    background: linear-gradient(135deg, #7267ef 0%, #4a3aff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 800;
}

/* Chart card live badge */
.chart-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(114, 103, 239, 0.1);
    color: #5b4ffd;
    font-weight: 700;
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 20px;
    letter-spacing: 0.02em;
}
.chart-badge i { font-size: 0.9rem; }

/* Financial card subtle top gradient border */
.financial-card {
    position: relative;
}
.financial-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #7267ef 0%, #a99bff 100%);
    border-radius: 16px 16px 0 0;
}

/* Financial Section Effects */
.financial-item { 
    background: #f8fafc; 
    border: 1px solid #f1f5f9;
    transition: all 0.25s ease;
}
.financial-item:hover {
    background: #f1f0ff;
    border-color: rgba(114, 103, 239, 0.25);
    transform: translateX(4px);
}

/* Modern Soft Background Badges */
.bg-soft-success { background-color: rgba(34, 197, 94, 0.12) !important; }
.bg-soft-info { background-color: rgba(6, 182, 212, 0.12) !important; }
.bg-soft-warning { background-color: rgba(245, 158, 11, 0.12) !important; }
.bg-soft-danger { background-color: rgba(239, 68, 68, 0.12) !important; }
.bg-soft-primary { background-color: rgba(114, 103, 239, 0.12) !important; }
.bg-soft-secondary { background-color: rgba(100, 116, 139, 0.12) !important; }

/* Modern Interactive Table Styling */
.table-modern { border-collapse: separate; border-spacing: 0 0px; }
.table-modern thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    text-uppercase: uppercase;
    font-size: 0.78rem;
    letter-spacing: 0.05em;
    padding: 14px 16px;
    border-bottom: 2px solid #e2e8f0;
}
.modern-row { transition: all 0.2s ease; cursor: default; }
.modern-row:hover {
    background-color: #f5f3ff !important;
}
.table-modern td {
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
    color: #334155;
    font-size: 0.92rem;
}
.small-badge { font-size: 0.72rem !important; letter-spacing: 0.03em; }

/* Status Dot Indicators */
.dot-indicator {
    width: 7px; height: 7px;
    border-radius: 50%;
    display: inline-block;
}

/* Modern Button styling */
.btn-modern-primary {
    background: linear-gradient(135deg, #7267ef 0%, #5b4ffd 100%);
    border: none;
    transition: all 0.25s ease;
}
.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(114, 103, 239, 0.4) !important;
    opacity: 0.97;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dashboard-container { p-2 !important; }
    .icon-box { width: 36px; height: 36px; font-size: 1.1rem; border-radius: 8px; }
    h3 { font-size: 1.25rem !important; }
    .stat-title { font-size: 0.78rem; }
    .table-modern td, .table-modern thead th { padding: 12px 10px; font-size: 0.85rem; }
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var options = {
        series: [{
            name: 'Sales',
            data: {!! json_encode($weeklySales) !!}
        }],
        chart: {
            type: 'area',
            height: 380, // Optimized matching height
            toolbar: { show: false },
            fontFamily: "'Plus Jakarta Sans', sans-serif",
            sparkline: { enabled: false }
        },
        stroke: { curve: 'smooth', width: 3.5, colors: ['#7267ef'] },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.35,
                opacityTo: 0.02,
                stops: [0, 95, 100]
            }
        },
        markers: {
            size: 0,
            colors: ['#7267ef'],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: { size: 6 }
        },
        dataLabels: { enabled: false },
        colors: ['#7267ef'],
        xaxis: {
            categories: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: '#64748b', fontWeight: 500 } }
        },
        yaxis: { 
            labels: { 
                offsetX: -10,
                style: { colors: '#64748b', fontWeight: 500 } 
            } 
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };

    var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
    chart.render();
});
</script>
@endpush