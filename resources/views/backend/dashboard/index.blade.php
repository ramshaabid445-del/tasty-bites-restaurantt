@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
              </div>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">POS System</a></li>
                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Customers (Today)</h6>
              <h4 class="mb-3">426 <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i> 15.3%</span></h4>
              <p class="mb-0 text-muted text-sm">Compared to <span class="text-primary">370</span> yesterday</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Active Tables</h6>
              <h4 class="mb-3">18 / 30 <span class="badge bg-light-success border border-success"><i class="ti ti-check"></i> 60%</span></h4>
              <p class="mb-0 text-muted text-sm"><span class="text-success">12</span> tables available right now</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Orders Received</h6>
              <h4 class="mb-3">145 <span class="badge bg-light-warning border border-warning"><i class="ti ti-trending-up"></i> 5.4%</span></h4>
              <p class="mb-0 text-muted text-sm"><span class="text-warning">15</span> pending in Kitchen</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Revenue</h6>
              <h4 class="mb-3">$3,078 <span class="badge bg-light-danger border border-danger"><i class="ti ti-trending-down"></i> 2.4%</span></h4>
              <p class="mb-0 text-muted text-sm">Estimated <span class="text-danger">$4,500</span> by EOD</p>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-8">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Customer Walk-ins</h5>
            <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-home" type="button" role="tab" aria-controls="chart-tab-home" aria-selected="true">Month</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile" aria-selected="false">Week</button>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="tab-content" id="chart-tab-tabContent">
                <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                  <div id="visitor-chart-1"></div>
                </div>
                <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel" aria-labelledby="chart-tab-profile-tab" tabindex="0">
                  <div id="visitor-chart"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-4">
          <h5 class="mb-3">Income Overview</h5>
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
              <h3 class="mb-3">$7,650</h3>
              <div id="income-overview-chart"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-8">
          <h5 class="mb-3">Recent Orders (KDS)</h5>
          <div class="card tbl-card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                  <thead>
                    <tr>
                      <th>ORDER NO.</th>
                      <th>ITEM DETAILS</th>
                      <th>QTY</th>
                      <th>STATUS</th>
                      <th class="text-end">AMOUNT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="#" class="text-muted">#ORD-001</a></td>
                      <td>Zinger Burger Meal</td>
                      <td>2</td>
                      <td><span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-success f-10 m-r-5"></i>Served</span></td>
                      <td class="text-end">$15.50</td>
                    </tr>
                    <tr>
                      <td><a href="#" class="text-muted">#ORD-002</a></td>
                      <td>BBQ Chicken Pizza (L)</td>
                      <td>1</td>
                      <td><span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-warning f-10 m-r-5"></i>Preparing</span></td>
                      <td class="text-end">$22.00</td>
                    </tr>
                    <tr>
                      <td><a href="#" class="text-muted">#ORD-003</a></td>
                      <td>Grilled Steak & Fries</td>
                      <td>3</td>
                      <td><span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-success f-10 m-r-5"></i>Served</span></td>
                      <td class="text-end">$48.00</td>
                    </tr>
                    <tr>
                      <td><a href="#" class="text-muted">#ORD-004</a></td>
                      <td>Iced Caramel Macchiato</td>
                      <td>4</td>
                      <td><span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-danger f-10 m-r-5"></i>Cancelled</span></td>
                      <td class="text-end">$18.50</td>
                    </tr>
                    <tr>
                      <td><a href="#" class="text-muted">#ORD-005</a></td>
                      <td>Fettuccine Alfredo</td>
                      <td>2</td>
                      <td><span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-warning f-10 m-r-5"></i>Preparing</span></td>
                      <td class="text-end">$26.00</td>
                    </tr>
                    <tr>
                      <td><a href="#" class="text-muted">#ORD-006</a></td>
                      <td>Caesar Salad</td>
                      <td>1</td>
                      <td><span class="d-flex align-items-center gap-2"><i class="fas fa-circle text-success f-10 m-r-5"></i>Served</span></td>
                      <td class="text-end">$8.50</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-4">
          <h5 class="mb-3">Analytics Report</h5>
          <div class="card">
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                Company Finance Growth<span class="h5 mb-0">+45.14%</span>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                Company Expenses Ratio<span class="h5 mb-0">0.58%</span>
              </a>
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                Business Risk Cases<span class="h5 mb-0">Low</span>
              </a>
            </div>
            <div class="card-body px-2">
              <div id="analytics-report-chart"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-8">
          <h5 class="mb-3">Sales Report</h5>
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
              <h3 class="mb-0">$7,650</h3>
              <div id="sales-report-chart"></div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 col-xl-4">
          <h5 class="mb-3">Transaction History</h5>
          <div class="card">
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                      <i class="ti ti-gift f-18"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Order #002434</h6>
                    <p class="mb-0 text-muted">Today, 2:00 AM</p>
                  </div>
                  <div class="flex-shrink-0 text-end">
                    <h6 class="mb-1">+ $1,430</h6>
                    <p class="mb-0 text-muted">78%</p>
                  </div>
                </div>
              </a>
              <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                      <i class="ti ti-message-circle f-18"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Order #984947</h6>
                    <p class="mb-0 text-muted">5 August, 1:45 PM</p>
                  </div>
                  <div class="flex-shrink-0 text-end">
                    <h6 class="mb-1">- $302</h6>
                    <p class="mb-0 text-muted">8%</p>
                  </div>
                </div>
              </a>
              <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <div class="avtar avtar-s rounded-circle text-danger bg-light-danger">
                      <i class="ti ti-settings f-18"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Order #988784</h6>
                    <p class="mb-0 text-muted">7 hours ago</p>
                  </div>
                  <div class="flex-shrink-0 text-end">
                    <h6 class="mb-1">- $682</h6>
                    <p class="mb-0 text-muted">16%</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>

      </div> </div> </div> @endsection@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Restaurant Overview</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item">Analytics</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h6 class="mb-2 f-w-400 text-muted">Total Revenue (Today)</h6>
                        <h4 class="mb-3">Rs {{ number_format($todayRevenue, 2) }} 
                            <span class="badge bg-light-success border border-success text-success"><i class="ti ti-trending-up"></i> Live</span>
                        </h4>
                        <p class="mb-0 text-muted text-sm">Updated just now</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h6 class="mb-2 f-w-400 text-muted">Table Occupancy</h6>
                        <h4 class="mb-3">{{ $activeTables }} / {{ $totalTables }} 
                            <span class="badge bg-light-info border border-info text-info"><i class="ti ti-table"></i> Tables</span>
                        </h4>
                        <p class="mb-0 text-muted text-sm text-info">{{ $totalTables - $activeTables }} tables available</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h6 class="mb-2 f-w-400 text-muted">Orders Received</h6>
                        <h4 class="mb-3">{{ $todayOrders }} 
                            <span class="badge bg-light-warning border border-warning text-warning"><i class="ti ti-shopping-cart"></i> Today</span>
                        </h4>
                        <p class="mb-0 text-muted text-sm">Through POS & Dine-in</p>
                    </div>
                </div>
            </div>
            
           <div class="col-md-6 col-xl-3">
    <div class="card shadow-none border">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Top Item Today</h6>
            <h4 class="mb-3">
                {{ $topItem->item_name ?? 'No Sales' }} 
                <span class="badge bg-light-danger border border-danger text-danger">
                    <i class="ti ti-star"></i> {{ $topItem->total_qty ?? 0 }} Sold
                </span>
            </h4>
            <p class="mb-0 text-muted text-sm">Most ordered item</p>
        </div>
    </div>
</div>

            <div class="col-md-12 col-xl-8">
                <h5 class="mb-3">Weekly Sales Performance</h5>
                <div class="card border shadow-none">
                    <div class="card-body">
                        <div id="sales-report-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xl-4">
                <h5 class="mb-3">Financial Status</h5>
                <div class="card border shadow-none">
                    <div class="card-body">
                        <h6 class="mb-2 f-w-400 text-muted">Total Sales This Week</h6>
                        <h3 class="mb-3">Rs {{ number_format($todayRevenue * 5.2, 0) }}</h3> <div class="list-group list-group-flush mt-4">
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span>Profit Margin</span><span class="fw-bold text-success">65%</span>
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

            <div class="col-md-12 col-xl-12">
                <h5 class="mb-3">Recent Transactions (Real-time)</h5>
                <div class="card tbl-card border shadow-none">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th>ORDER NO.</th>
                                        <th>TYPE</th>
                                        <th>TIME</th>
                                        <th>STATUS</th>
                                        <th class="text-end pe-4">AMOUNT</th>
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
                <span class="d-flex align-items-center gap-2">
                    <i class="fas fa-circle text-success f-10 m-r-5"></i>Paid
                </span>
            @else
                <span class="d-flex align-items-center gap-2">
                    <i class="fas fa-circle text-warning f-10 m-r-5"></i>Pending
                </span>
            @endif
        </td>
        <td class="text-end pe-4 fw-bold">Rs {{ number_format($order->total_amount, 2) }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center py-3 text-muted">No transactions found for today.</td>
    </tr>
    @endforelse
</tbody>
                            </table>
                        </div>
                    </div>
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