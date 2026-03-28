@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Live Orders</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Order Management</li>
                            <li class="breadcrumb-item" aria-current="page">Live Orders</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card border-top border-3 border-warning">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">#ORD-00102</h5>
                        <span class="badge bg-light-warning text-warning"><i class="ti ti-clock"></i> 10 Mins Ago</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Type: <strong>Dine-in (Table 4)</strong></span>
                            <span class="badge bg-primary">Preparing</span>
                        </div>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                <span>2x Zinger Burger</span> <span class="text-muted">$12.00</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                <span>1x Large Fries</span> <span class="text-muted">$3.50</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                <span>2x Coke (Regular)</span> <span class="text-muted">$4.00</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Total: $19.50</h6>
                        <button class="btn btn-sm btn-success">Mark as Ready</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card border-top border-3 border-danger">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">#ORD-00103</h5>
                        <span class="badge bg-light-danger text-danger"><i class="ti ti-clock"></i> 25 Mins Ago</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Type: <strong>Takeaway</strong></span>
                            <span class="badge bg-danger">Delayed</span>
                        </div>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                <span>1x BBQ Chicken Pizza (L)</span> <span class="text-muted">$18.00</span>
                            </li>
                            <li class="list-group-item px-0 py-2 d-flex justify-content-between text-danger">
                                <small>Addon: Extra Cheese</small>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Total: $18.00</h6>
                        <button class="btn btn-sm btn-success">Mark as Ready</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection