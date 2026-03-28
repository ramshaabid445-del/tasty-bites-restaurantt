@extends('backend.layouts.app')

@section('title', 'Loyalty Program')

@section('content')
<div class="page-header mb-4">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h4 class="mb-0">Loyalty Management</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card  overflow-hidden" style="border-radius: 12px; background: linear-gradient(45deg, #7267ef, #a389f4);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="avtar avtar-lg bg-white bg-opacity-25 rounded-circle">
                                <i class="ti ti-gift text-white f-24"></i>
                            </div>
                            <span class="badge bg-white bg-opacity-25 rounded-pill text-white">Lifetime</span>
                        </div>
                        <h6 class="text-white text-opacity-75 mb-1">Total Points Awarded</h6>
                        <h2 class="text-white fw-black mb-0">25,400 <small class="f-14 fw-normal text-opacity-50">Pts</small></h2>
                    </div>
                </div>

                <div class="card  mt-3" style="border-radius: 12px;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="ti ti-settings me-2 text-primary"></i> Points Configuration</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">100 PKR =</span>
                            <span class="badge bg-light-primary text-primary fw-bold">10 Points</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Redeem Rate:</span>
                            <span class="badge bg-light-success text-success fw-bold">1 Point = 0.5 PKR</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card " style="border-radius: 12px;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                        <h5 class="mb-0 fw-bold"><i class="ti ti-users me-2 text-primary"></i> Top Loyal Customers</h5>
                        <button class="btn btn-sm btn-primary rounded-pill px-3">View All</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 border-0 text-muted small">CUSTOMER</th>
                                        <th class="border-0 text-muted small">LAST ORDER</th>
                                        <th class="border-0 text-muted small">POINTS BALANCE</th>
                                        <th class="border-0 text-muted small text-end pe-4">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-info text-info rounded-circle me-2">R</div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Rohan Ali</h6>
                                                    <small class="text-muted">0310-XXXXXXX</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>2 hours ago</td>
                                        <td><span class="fw-bold text-primary">5,200</span></td>
                                        <td class="text-end pe-4"><span class="badge bg-light-success text-success px-3">Gold</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-warning text-warning rounded-circle me-2">A</div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Ahmad Raza</h6>
                                                    <small class="text-muted">0321-XXXXXXX</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Yesterday</td>
                                        <td><span class="fw-bold text-primary">3,150</span></td>
                                        <td class="text-end pe-4"><span class="badge bg-light-warning text-warning px-3">Silver</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 py-3 text-center text-muted small" colspan="4">
                                            More data will populate as orders are placed.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for better presentation */
    .fw-black { font-weight: 900; }
    .bg-light-primary { background: rgba(114, 103, 239, 0.1); }
    .bg-light-success { background: rgba(40, 167, 69, 0.1); }
    .bg-light-info { background: rgba(23, 162, 184, 0.1); }
    .bg-light-warning { background: rgba(255, 193, 7, 0.1); }
    .avtar-s { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-2px); }
</style>
@endsection