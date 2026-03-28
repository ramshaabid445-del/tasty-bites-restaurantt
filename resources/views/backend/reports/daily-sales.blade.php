@extends('backend.layouts.app')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark">Daily Sales Report</h2>
        <p class="text-muted">Overview for {{ $date->format('d M, Y') }}</p>
    </div>
    <div class="col-md-6 text-md-end">
        <form action="" method="GET" class="d-inline-block">
            <input type="date" name="date" value="{{ $date->format('Y-m-d') }}" class="form-control d-inline-block w-auto " onchange="this.form.submit()">
        </form>
        <button onclick="window.print()" class="btn btn-secondary shadow-sm ms-2"><i class="ti ti-printer me-1"></i> Print</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card  bg-primary text-white p-3" style="border-radius: 15px;">
            <small>Total Sales (Net)</small>
            <h2 class="fw-bold mb-0">Rs {{ number_format($stats->total_sales ?? 0) }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card  bg-white p-3" style="border-radius: 15px;">
            <small class="text-muted">Total Orders</small>
            <h2 class="fw-bold mb-0 text-dark">{{ $stats->total_orders ?? 0 }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card  bg-white p-3" style="border-radius: 15px;">
            <small class="text-muted">Total Tax</small>
            <h2 class="fw-bold mb-0 text-dark">Rs {{ number_format($stats->total_tax ?? 0) }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card  bg-white p-3" style="border-radius: 15px;">
            <small class="text-muted">Cash vs Card</small>
            <div class="d-flex gap-2 mt-1">
                @foreach($payments as $p)
                <span class="badge bg-light-info text-dark border small">{{ strtoupper($p->payment_method) }}: {{ number_format($p->amount) }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card  h-100" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">🔥 Best Selling Items</h5>
            </div>
            <div class="card-body p-4">
                @foreach($bestSellers as $item)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">{{ $item->item_name }}</h6>
                        <small class="text-muted">{{ $item->qty }} units sold</small>
                    </div>
                    <span class="fw-bold text-primary">Rs {{ number_format($item->total) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card  h-100" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Orders Detail</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-uppercase">
                                <th class="ps-4">Order #</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th class="pe-4">Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $o)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">#{{ substr($o->order_number, -6) }}</td>
                                <td><span class="badge {{ $o->status == 'completed' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }}">{{ strtoupper($o->status) }}</span></td>
                                <td class="fw-bold text-dark">Rs {{ number_format($o->total_amount) }}</td>
                                <td class="pe-4"><span class="small text-muted">{{ strtoupper($o->payment_method) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endsection