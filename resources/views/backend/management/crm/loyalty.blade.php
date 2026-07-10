@extends('backend.layouts.app')

@section('title', 'Loyalty Program')

@section('content')
<div class="container-fluid p-4 loyalty-container">
    {{-- Header --}}
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h2 class="fw-extrabold text-dark tracking-tight mb-1" style="font-size: 1.75rem;">Loyalty Management</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted fw-medium">Dashboard</a></li>
                    <li class="breadcrumb-item small active text-primary fw-semibold" aria-current="page">Loyalty Points</li>
                </ol>
            </nav>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            <button type="button" class="btn btn-modern-primary shadow-sm px-4 py-2 rounded-pill fw-bold text-white" data-bs-toggle="modal" data-bs-target="#addPointsModal">
                <i class="ti ti-plus me-1"></i> Add Manual Points
            </button>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column --}}
        <div class="col-xl-4 col-lg-5">
            {{-- ULTRA-PREMIUM LOYALTY CARD --}}
            <div class="premium-loyalty-card position-relative overflow-hidden mb-4 shadow border-0">
                {{-- Decorative Blurred Glow Rings --}}
                <div class="glow-ring-1"></div>
                <div class="glow-ring-2"></div>
                
                {{-- Floating Gift Icon --}}
                <i class="ti ti-gift floating-bg-icon"></i>
                
                <div class="position-relative z-3">
                    <div class="glass-icon-wrapper mb-3">
                        <i class="ti ti-star-filled text-white" style="font-size: 1.25rem;"></i>
                    </div>
                    
                    <p class="card-subtitle-text text-uppercase tracking-wider mb-1">Total Points Awarded</p>
                    <h1 class="card-main-title fw-extrabold text-white mb-0">
                        {{ number_format($totalPoints ?? 0) }} <span class="points-badge-text">Pts</span>
                    </h1>
                </div>
            </div>

            {{-- Points Engine Card --}}
            <div class="card border-0 shadow-sm panel-card" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="fw-bold text-dark mb-0 small tracking-wider text-uppercase text-secondary">Points Engine</h6>
                        <button class="btn btn-sm btn-soft-primary rounded-pill px-3 fw-bold tracking-wide">Edit Rules</button>
                    </div>
                    
                    <div class="engine-rate-strip d-flex align-items-center p-3 mb-3 rounded-3" style="border-left: 5px solid #7267ef;">
                        <div class="flex-grow-1">
                            <small class="text-muted d-block extra-small fw-bold mb-1">Earning Rate</small>
                            <span class="fw-extrabold text-dark" style="font-size: 1.05rem;">100 PKR = <span class="text-primary">10 Pts</span></span>
                        </div>
                        <div class="strip-icon bg-soft-primary text-primary"><i class="ti ti-arrow-up-right"></i></div>
                    </div>
                    
                    <div class="engine-rate-strip d-flex align-items-center p-3 rounded-3" style="border-left: 5px solid #22c55e;">
                        <div class="flex-grow-1">
                            <small class="text-muted d-block extra-small fw-bold mb-1">Redeem Rate</small>
                            <span class="fw-extrabold text-dark" style="font-size: 1.05rem;">1 Pt = <span class="text-success">0.5 PKR</span></span>
                        </div>
                        <div class="strip-icon bg-soft-success text-success"><i class="ti ti-arrow-down-left"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Table --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm h-100 panel-card" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 border-bottom d-flex align-items-center">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Top Loyal Customers</h5>
                        <p class="text-muted small mb-0">List of high-tier points spenders</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">CUSTOMER</th>
                                    <th class="text-center">POINTS</th>
                                    <th class="text-end pe-4">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers ?? [] as $customer)
                                <tr class="modern-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-box me-3 fw-extrabold">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark small-title-fix">{{ $customer->name }}</h6>
                                                <small class="text-muted fw-medium fs-7 d-flex align-items-center gap-1"><i class="ti ti-phone text-secondary small-icon"></i>{{ $customer->phone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-extrabold text-primary" style="font-size: 1.05rem;">
                                        {{ number_format($customer->loyalty_points ?? 0) }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="badge rounded-pill bg-soft-success text-success px-3 py-2 fw-bold font-tracking-badge"><span class="pulse-dot"></span>GOLD</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-5 text-muted fw-medium">No loyal customers found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Section --}}
<div class="modal fade" id="addPointsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; background: #ffffff;">
            <div class="modal-header border-0 p-4 pb-0 position-relative">
                <div>
                    <h5 class="modal-title fw-extrabold text-dark" style="font-size: 1.25rem;">Add Manual Points</h5>
                    <p class="text-muted small mb-0">Manually inject rewards into user profiles</p>
                </div>
                <button type="button" class="btn-close custom-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.crm.loyalty.add') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 position-relative">
                        <label class="form-label small fw-bold text-dark mb-2">Select Customer</label>
                        <select class="form-select modern-input" name="customer_id" required>
                            @foreach($customers ?? [] as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-dark mb-2">Points Amount</label>
                        <input type="number" name="points" class="form-control modern-input" placeholder="e.g. 500" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-modern-primary rounded-pill px-4 w-100 text-white fw-bold py-2 shadow-sm">Confirm & Allocate Points</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Loyalty Screen Configuration */
.loyalty-container {
    background: #f8fafc;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}
.fw-extrabold { font-weight: 800; }
.panel-card { border: 1px solid rgba(226, 232, 240, 0.8) !important; }

/* PREMIUM CARD GRADIENT & BLUR EFFECTS */
.premium-loyalty-card {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
    border-radius: 20px !important;
    padding: 32px !important;
    min-height: 185px !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.premium-loyalty-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.25), 0 10px 10px -5px rgba(79, 70, 229, 0.15) !important;
}

/* Glass Icon Wrapper */
.glass-icon-wrapper {
    background: rgba(255, 255, 255, 0.18) !important;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    width: 44px; height: 44px;
    border-radius: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: 1px solid rgba(255, 255, 255, 0.25);
}

.card-subtitle-text {
    color: rgba(255, 255, 255, 0.75) !important;
    font-size: 0.82rem !important;
    font-weight: 600 !important;
}
.card-main-title {
    font-size: 2.6rem !important;
    letter-spacing: -0.02em;
}
.points-badge-text {
    font-size: 1.1rem !important;
    opacity: 0.7 !important;
    font-weight: 500;
}

/* Glow Ring Graphics */
.glow-ring-1 {
    position: absolute; width: 140px; height: 140px;
    background: rgba(255, 255, 255, 0.06); border-radius: 50%;
    top: -40px; right: -20px; z-index: 1;
}
.glow-ring-2 {
    position: absolute; width: 200px; height: 200px;
    background: rgba(255, 255, 255, 0.03); border-radius: 50%;
    top: -70px; right: -50px; z-index: 1;
}
.floating-bg-icon {
    position: absolute !important;
    right: -15px !important;
    bottom: -15px !important;
    font-size: 120px !important;
    color: white !important;
    opacity: 0.08 !important;
    z-index: 2;
    transition: all 0.5s ease;
}
.premium-loyalty-card:hover .floating-bg-icon {
    transform: rotate(-10deg) scale(1.1);
}

/* Strips Engine Styling */
.engine-rate-strip {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}
.engine-rate-strip:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}
.strip-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.95rem; font-weight: bold;
}

/* Modern Minimal Tables */
.table-modern thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    text-uppercase: uppercase;
    font-size: 0.76rem;
    letter-spacing: 0.05em;
    padding: 14px 16px;
    border-bottom: 2px solid #e2e8f0;
}
.modern-row { transition: background-color 0.2s ease; }
.modern-row:hover { background-color: #f8fafc !important; }
.table-modern td {
    padding: 15px 16px;
    border-bottom: 1px solid #e2e8f0;
}

/* User Profile Elements */
.avatar-box {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, #eeecfd 0%, #e0dcfe 100%);
    color: #7267ef;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.95rem;
}
.small-title-fix { font-size: 0.9rem; color: #1e293b; }
.fs-7 { font-size: 0.78rem !important; }
.small-icon { font-size: 0.75rem; }

/* Status Dot with Pulse */
.font-tracking-badge {
    font-size: 0.72rem !important; letter-spacing: 0.04em;
    display: inline-flex; align-items: center; gap: 5px;
}
.pulse-dot {
    width: 6px; height: 6px; background-color: #22c55e;
    border-radius: 50%; display: inline-block;
    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
    animation: pulseEffect 2s infinite;
}

/* Soft Styling Elements */
.bg-soft-primary { background-color: rgba(114, 103, 239, 0.12) !important; }
.bg-soft-success { background-color: rgba(34, 197, 94, 0.12) !important; }
.extra-small { font-size: 0.7rem; letter-spacing: 0.04em; color: #64748b !important; }
.btn-soft-primary {
    background: rgba(114, 103, 239, 0.1); color: #7267ef; border: none;
    transition: all 0.2s ease;
}
.btn-soft-primary:hover { background: #7267ef; color: white; }

/* Input Elements */
.modern-input {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    padding: 12px 16px !important;
    border-radius: 12px !important;
    color: #334155 !important;
    font-size: 0.9rem !important;
    transition: all 0.2s ease !important;
}
.modern-input:focus {
    background: #ffffff !important;
    border-color: #7267ef !important;
    box-shadow: 0 0 0 4px rgba(114, 103, 239, 0.12) !important;
}

/* Action Button */
.btn-modern-primary {
    background: linear-gradient(135deg, #7267ef 0%, #5b4ffd 100%);
    border: none; transition: all 0.2s ease;
}
.btn-modern-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(114, 103, 239, 0.3) !important;
}

@keyframes pulseEffect {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

/* Mobile Screen Scaling */
@media (max-width: 768px) {
    .premium-loyalty-card { padding: 24px !important; min-height: 160px !important; }
    .card-main-title { font-size: 2.1rem !important; }
    .table-modern td, .table-modern thead th { padding: 12px 10px; font-size: 0.85rem; }
}
</style>
@endsection