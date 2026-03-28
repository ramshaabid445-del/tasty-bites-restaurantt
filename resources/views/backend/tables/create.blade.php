@extends('backend.layouts.app')

@section('content')
<div class="page-header">
            <div class="page-block">
                <div class="row align-items-center mb-3">
                    <div class="col-md-12">
                        <div class="page-header-title d-flex justify-content-between align-items-center">
                            <h5 class="m-b-10">Add New Table</h5>
                            <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Back to Tables
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header border-bottom bg-light">
                        <h5 class="mb-0">Table Details</h5>
                    </div>
                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.tables.store') }}" method="POST">
                            @csrf
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Table Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g., Table 1, VIP Lounge A" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Capacity (Persons) <span class="text-danger">*</span></label>
                                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', 4) }}" min="1" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Current Status</label>
                                    <select name="status" class="form-select">
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="text-end">
                                <button type="reset" class="btn btn-light me-2">Clear</button>
                                <button type="submit" class="btn btn-primary">Save Table</button>
                            </div>
                        </form>

                    </div>
                </div>
            @endsection