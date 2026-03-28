@extends('backend.layouts.app')
@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">General Settings</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li class="breadcrumb-item">System Configuration</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5>Restaurant Profile</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Restaurant Name</label>
                            <input type="text" name="restaurant_name" class="form-control" value="{{ $settings['restaurant_name'] ?? '' }}" placeholder="e.g. Tasty Bites">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Contact Number</label>
                            <input type="text" name="restaurant_phone" class="form-control" value="{{ $settings['restaurant_phone'] ?? '' }}" placeholder="+92 300 1234567">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Address</label>
                            <textarea name="restaurant_address" class="form-control" rows="3" placeholder="Full street address...">{{ $settings['restaurant_address'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Currency Symbol</label>
                            <input type="text" name="currency_symbol" class="form-control" value="{{ $settings['currency_symbol'] ?? 'Rs' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Default Tax (%)</label>
                            <input type="number" name="default_tax" class="form-control" value="{{ $settings['default_tax'] ?? '0' }}">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ti ti-device-floppy me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Branding</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <label class="form-label d-block text-start fw-600">Current Logo</label>
                    <div class="p-4 border rounded-3 bg-light d-inline-block">
                        @if(isset($settings['restaurant_logo']))
                            <img src="{{ asset($settings['restaurant_logo']) }}" alt="Logo" class="img-fluid" style="max-height: 80px;">
                        @else
                            <div class="text-muted"><i class="ti ti-photo fs-1"></i><br>No Logo Uploaded</div>
                        @endif
                    </div>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label fw-600">Upload New Logo</label>
                        <input type="file" name="restaurant_logo" class="form-control">
                        <small class="text-muted">Recommended: 200x80px PNG</small>
                    </div>
                    <button type="submit" class="btn btn-light-primary w-100">Update Branding</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
