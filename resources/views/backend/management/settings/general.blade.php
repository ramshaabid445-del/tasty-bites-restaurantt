@extends('backend.layouts.master')
@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Settings</a></li>
                            <li class="breadcrumb-item" aria-current="page">General Info</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Restaurant General Settings</h5>
                        @if(isset($settings['restaurant_logo']))
                            <img src="{{ asset($settings['restaurant_logo']) }}" alt="Logo" style="height: 40px;">
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Restaurant Name</label>
                                    <input type="text" name="restaurant_name" class="form-control" value="{{ $settings['restaurant_name'] ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="restaurant_phone" class="form-control" value="{{ $settings['restaurant_phone'] ?? '' }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="restaurant_address" class="form-control" rows="2">{{ $settings['restaurant_address'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Currency Symbol (e.g. Rs, $)</label>
                                    <input type="text" name="currency_symbol" class="form-control" value="{{ $settings['currency_symbol'] ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tax (%)</label>
                                    <input type="number" name="default_tax" class="form-control" value="{{ $settings['default_tax'] ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Restaurant Logo</label>
                                    <input type="file" name="restaurant_logo" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary shadow-2">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection