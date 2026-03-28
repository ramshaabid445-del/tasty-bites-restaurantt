@extends('backend.layouts.app')

@section('title', 'Add New Supplier')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card " style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h4 class="fw-bold mb-0">Register New Supplier</h4>
                <p class="text-muted small">Fill in the details below to add a new vendor to your inventory.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.inventory.suppliers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. John Doe" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="e.g. ABC Wholesale Ltd">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="e.g. 03001234567" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="e.g. supplier@example.com">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Opening Balance (Rs.)</label>
                            <input type="number" step="0.01" name="opening_balance" class="form-control" value="0.00">
                            <small class="text-muted">Initial amount you owe to this supplier.</small>
                        </div>

                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" checked>
                                <label class="form-check-label fw-semibold" for="statusSwitch">Active Account</label>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-semibold">Business Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Full office/shop address..."></textarea>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <a href="{{ route('admin.inventory.suppliers.index') }}" class="btn btn-light px-4 me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Save Supplier</button>
                    </div>
                </form>
            @endsection