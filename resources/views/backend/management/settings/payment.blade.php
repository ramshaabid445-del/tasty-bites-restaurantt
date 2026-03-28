@extends('backend.layouts.app')
@section('content')
<div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Payment Methods Configuration</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="payment_cash_status" value="1" {{ get_setting('payment_cash_status') ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold">Enable Cash Payment</label>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="payment_card_status" value="1" {{ get_setting('payment_card_status') ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold">Enable Card/Machine Payment</label>
                                    </div>
                                </div>

                                <hr>

                                <div class="col-md-12">
                                    <h5>Online Gateway (Stripe)</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stripe Key</label>
                                            <input type="text" name="stripe_key" class="form-control" value="{{ get_setting('stripe_key') }}" placeholder="pk_test_...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stripe Secret</label>
                                            <input type="password" name="stripe_secret" class="form-control" value="{{ get_setting('stripe_secret') }}" placeholder="sk_test_...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Update Payment Settings</button>
                        </form>
                    </div>
                </div>
            @endsection
