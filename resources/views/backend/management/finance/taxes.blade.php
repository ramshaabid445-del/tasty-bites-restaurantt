@extends('backend.layouts.app')

@section('title', 'Tax Configuration')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-circle-check me-2 f-20"></i> 
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header bg-primary py-3">
                        <div class="d-flex align-items-center">
                            <div class="avtar avtar-s bg-white bg-opacity-25 text-white me-2">
                                <i class="ti ti-receipt-tax f-20"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-white">Tax Setup & Configuration</h5>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="{{ route('admin.finance.taxes.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-muted small text-uppercase">Tax Name (e.g. GST)</label>
                                    <div class="input-group border-2 rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-light border-0"><i class="ti ti-tag text-muted"></i></span>
                                        <input type="text" name="tax_name" 
                                               class="form-control form-control-lg border-0 @error('tax_name') is-invalid @enderror" 
                                               value="{{ old('tax_name', $tax->tax_name ?? '') }}" 
                                               placeholder="Enter Tax Name">
                                    </div>
                                    @error('tax_name') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-muted small text-uppercase">Tax Rate (%)</label>
                                    <div class="input-group border-2 rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-light border-0"><i class="ti ti-percentage text-muted"></i></span>
                                        <input type="number" step="0.01" name="tax_rate" 
                                               class="form-control form-control-lg border-0 @error('tax_rate') is-invalid @enderror" 
                                               value="{{ old('tax_rate', $tax->tax_rate ?? 0) }}" 
                                               placeholder="0.00">
                                    </div>
                                    @error('tax_rate') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="mb-4 p-4 bg-light rounded-3 border">
                                <div class="form-check form-switch d-flex align-items-center justify-content-between ps-0">
                                    <div>
                                        <h6 class="fw-bold mb-1">Enable Tax Calculation</h6>
                                        <p class="text-muted small mb-0">Apply this tax to all future POS orders and invoices.</p>
                                    </div>
                                    <input class="form-check-input ms-0" type="checkbox" name="is_active" value="1" 
                                           style="width: 50px; height: 25px; cursor: pointer;"
                                           {{ (isset($tax) && $tax->is_active) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow border-0 rounded-3">
                                <i class="ti ti-device-floppy me-2"></i> 
                                <span class="fw-bold">SAVE TAX CONFIGURATION</span>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <div class="badge bg-light-secondary text-muted p-2 px-3 rounded-pill">
                        <i class="ti ti-info-circle me-1"></i> These settings are synced with your POS calculation engine.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Professional UI Enhancements */
    .form-control:focus { box-shadow: none; background: #fff; border-color: #7267ef; }
    .input-group:focus-within { border-color: #7267ef !important; box-shadow: 0 0 0 0.2rem rgba(114, 103, 239, 0.15); }
    .form-check-input:checked { background-color: #7267ef; border-color: #7267ef; }
    .bg-light-secondary { background: rgba(108, 117, 125, 0.1); }
    .avtar-s { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
</style>
@endsection