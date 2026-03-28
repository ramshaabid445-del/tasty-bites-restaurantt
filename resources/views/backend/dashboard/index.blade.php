@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Restaurant Overview</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="ti ti-home"></i> Admin</a></li>
                    <li class="breadcrumb-item">Real-time Analytics</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 text-muted">Today's Revenue</h6>
                    <div class="avatar avatar-s bg-light-success text-success">
                        <i class="ti ti-currency-dollar fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1">Rs {{ number_format($todayRevenue, 0) }}</h3>
                <p class="mb-0 text-sm"><span class="text-success fw-600"><i class="ti ti-trending-up"></i> Live</span> updates</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 text-muted">Occupancy</h6>
                    <div class="avatar avatar-s bg-light-info text-info">
                        <i class="ti ti-armchair fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1">{{ $activeTables }} / {{ $totalTables }}</h3>
                <p class="mb-0 text-sm"><span class="text-info fw-600">{{ $totalTables - $activeTables }}</span> tables free</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 text-muted">Today's Orders</h6>
                    <div class="avatar avatar-s bg-light-warning text-warning">
                        <i class="ti ti-shopping-cart fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1">{{ $todayOrders }}</h3>
                <p class="mb-0 text-sm">Processed today</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0 text-muted">Popular Item</h6>
                    <div class="avatar avatar-s bg-light-danger text-danger">
                        <i class="ti ti-flame fs-4"></i>
                    </div>
                </div>
                <h4 class="mb-1 text-truncate">{{ $topItem->item_name ?? 'No Sales' }}</h4>
                <p class="mb-0 text-sm"><span class="text-danger fw-600">{{ $topItem->total_qty ?? 0 }}</span> units sold</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Weekly Sales Performance</h5>
                <button class="btn btn-sm btn-light-primary">View Report</button>
            </div>
            <div class="card-body">
                <div id="sales-report-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5>Financial Status</h5>
            </div>
            <div class="card-body">
                <h6 class="mb-2 text-muted">Weekly Sales</h6>
                <h2 class="mb-4">Rs {{ number_format($todayRevenue * 5.2, 0) }}</h2>
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span>Profit Margin</span><span class="badge bg-light-success text-success">65%</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span>Tax Collected</span><span class="fw-bold">5%</span>
                    </div>
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center border-0">
                        <span>Risk Level</span><span class="badge bg-light-success text-success">Low</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Recent Real-time Transactions</h5>
                <a href="{{ route('admin.orders.history') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ORDER NO.</th>
                                <th>TYPE</th>
                                <th>TIME</th>
                                <th>STATUS</th>
                                <th class="text-end">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-primary">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light-secondary text-dark">
                                        {{ ucfirst($order->order_type) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($order->payment_status == 'paid')
                                        <span class="badge bg-light-success text-success">Paid</span>
                                    @else
                                        <span class="badge bg-light-warning text-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold text-dark">Rs {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No transactions found for today.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        series: [{
            name: 'Sales',
            data: {!! json_encode($weeklySales) !!}
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        colors: ['#007bff'],
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        }
    };
    var chart = new ApexCharts(document.querySelector("#sales-report-chart"), options);
    chart.render();
</script>
@endpush
