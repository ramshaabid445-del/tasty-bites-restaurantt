@extends('backend.layouts.app')

@section('title', 'Tax Configuration')

@section('content')
<div class="container-fluid p-0">
    {{-- Header Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h4 class="fw-bold text-dark mb-1">Financial Settings</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item small active">Tax Configuration</li>
                </ol>
            </nav>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            <div class="d-inline-flex align-items-center bg-white border px-3 py-2 rounded-2 shadow-sm">
                <span class="status-dot bg-success me-2"></span>
                <small class="fw-bold text-uppercase text-muted" style="font-size: 10px;">System Active</small>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center p-3 animate__animated animate__fadeIn">
            <i class="ti ti-circle-check-filled fs-4 me-3"></i>
            <span class="fw-medium">{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 d-flex align-items-stretch">
        {{-- Left Side: Form --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header bg-white border-0 p-4 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                            <i class="ti ti-settings-automation fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Tax Parameters</h5>
                            <p class="text-muted small mb-0">Configure how taxes are applied to POS invoices</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.finance.taxes.update') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-2 small text-uppercase">Tax Display Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="ti ti-type text-muted"></i></span>
                                    <input type="text" name="tax_name" 
                                           class="form-control bg-light border-0 py-3" 
                                           value="{{ old('tax_name', $tax->tax_name ?? '') }}" 
                                           placeholder="e.g. GST / Sales Tax">
                                </div>
                                <small class="text-muted mt-2 d-block">This name will be printed on the invoice.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-2 small text-uppercase">Tax Rate (%)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="ti ti-percentage text-muted"></i></span>
                                    <input type="number" step="0.01" name="tax_rate" 
                                           class="form-control bg-light border-0 py-3" 
                                           value="{{ old('tax_rate', $tax->tax_rate ?? 0) }}">
                                </div>
                                <small class="text-muted mt-2 d-block">Enter percentage (e.g. 17 or 5).</small>
                            </div>
                        </div>

                        <div class="mt-4 p-4 rounded-3 bg-light border">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white p-2 rounded-2 me-3">
                                        <i class="ti ti-power fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Tax Calculation Logic</h6>
                                        <p class="text-muted small mb-0">Toggle to enable/disable tax on checkout.</p>
                                    </div>
                                </div>
                                <div class="form-check form-switch p-0">
                                    <input class="form-check-input ms-0 custom-switch" type="checkbox" name="is_active" value="1" 
                                           style="width: 3rem; height: 1.5rem;"
                                           {{ (isset($tax) && $tax->is_active) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">
                                <i class="ti ti-device-floppy me-1"></i> Update Configuration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Side: Bill Preview --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #f1f4f9;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <i class="ti ti-receipt text-primary me-2 fs-5"></i>
                        <h6 class="text-dark fw-bold mb-0 small text-uppercase">Preview Output</h6>
                    </div>
                    
                    {{-- Realistic Receipt --}}
                    <div class="bg-white p-4 shadow-sm border" style="border-radius: 8px;">
                        <div class="text-center mb-4">
                            <h5 class="fw-bold text-dark mb-0">STORE RECEIPT</h5>
                            <small class="text-muted">Terminal #001</small>
                        </div>

                        <div class="py-3 border-top border-bottom border-dashed mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal</span>
                                <span class="fw-bold text-dark small">1,000.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-primary fw-bold small">{{ $tax->tax_name ?? 'Tax' }} ({{ $tax->tax_rate ?? 0 }}%)</span>
                                <span class="text-primary fw-bold small">+ {{ number_format(1000 * ($tax->tax_rate ?? 0) / 100, 2) }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold text-dark">TOTAL</span>
                            <span class="h5 fw-bold text-primary mb-0">Rs. {{ number_format(1000 + (1000 * ($tax->tax_rate ?? 0) / 100), 2) }}</span>
                        </div>

                        <div class="text-center pt-3 border-top opacity-25">
                            <div style="height: 30px; background: repeating-linear-gradient(90deg, #000 0 1px, transparent 1px 3px);"></div>
                            <small style="font-size: 8px;">THANK YOU FOR SHOPPING</small>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 mt-4 small mb-0 rounded-3">
                        <i class="ti ti-info-circle me-1"></i> Note: Taxes apply to all new orders instantly after saving.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Clean UI Adjustments */
    .status-dot { height: 8px; width: 8px; border-radius: 50%; display: inline-block; animation: blink 1.5s infinite; }
    @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }

    .input-group-text { border-radius: 8px 0 0 8px; }
    .form-control { border-radius: 0 8px 8px 0 !important; }
    .form-control:focus { background-color: #fff !important; border: 1px solid #7267ef !important; }
    
    .custom-switch { cursor: pointer; }
    .custom-switch:checked { background-color: #7267ef !important; border-color: #7267ef !important; }
    
    .border-dashed { border-style: dashed !important; border-width: 1px 0 !important; }
    .btn-primary { background-color: #7267ef !important; border-color: #7267ef !important; transition: all 0.3s ease; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(114, 103, 239, 0.3); }

    .card { transition: none !important; } /* Stop cards from jumping on hover */
</style>
@endsection