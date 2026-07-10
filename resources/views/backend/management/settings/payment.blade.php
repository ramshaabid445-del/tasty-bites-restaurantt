@extends('backend.layouts.app')

@section('title', 'Payment Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-10 col-lg-8 col-xl-7">
            
            {{-- Header (Centered) --}}
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark mb-1">Payment Configuration</h4>
                <p class="text-muted small">Manage your payment methods and API keys.</p>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                {{-- Main Card --}}
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-4 p-md-5">
                        
                        {{-- Method Selection --}}
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-light-f8">
                                    <span class="fw-semibold text-dark">Cash Payment</span>
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input custom-switch" type="checkbox" name="payment_cash_status" value="1" {{ get_setting('payment_cash_status') ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-light-f8">
                                    <span class="fw-semibold text-dark">Card Payment</span>
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input custom-switch" type="checkbox" name="payment_card_status" value="1" {{ get_setting('payment_card_status') ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Stripe Section --}}
                        <div class="mb-5">
                            <h6 class="fw-bold text-dark mb-3">Online Gateway (Stripe)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Stripe Public Key</label>
                                    <input type="text" name="stripe_key" class="form-control standard-input" 
                                           value="{{ get_setting('stripe_key') }}" placeholder="pk_test_...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Stripe Secret Key</label>
                                    <input type="password" name="stripe_secret" class="form-control standard-input" 
                                           value="{{ get_setting('stripe_secret') }}" placeholder="sk_test_...">
                                </div>
                            </div>
                        </div>

                        {{-- Action Button (Centered) --}}
                        <div class="text-center pt-3 border-top mt-4">
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-none" style="border-radius: 8px; padding-top: 10px; padding-bottom: 10px;">
                                Save Configurations
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-light-f8 { background-color: #f8f9fa; }
    
    .standard-input {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
    }
    .standard-input:focus {
        border-color: #7267ef;
        box-shadow: 0 0 0 3px rgba(114, 103, 239, 0.1);
    }

    .custom-switch {
        width: 40px !important;
        height: 20px !important;
        cursor: pointer;
    }
    .custom-switch:checked {
        background-color: #7267ef;
        border-color: #7267ef;
    }

    .btn-primary {
        background-color: #7267ef;
        border-color: #7267ef;
    }
    .btn-primary:hover {
        background-color: #5e54d6;
        border-color: #5e54d6;
    }
</style>
@endsection