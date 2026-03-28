@extends('backend.layouts.app')

@section('content')
<div class="page-header">
            <div class="page-block">
                <div class="row align-items-center mb-3">
                    <div class="col-md-12">
                        <div class="page-header-title d-flex justify-content-between align-items-center">
                            <h5 class="m-b-10">Edit Addon</h5>
                            <a href="{{ route('admin.addons.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Back to Addons
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
                        <h5 class="mb-0">Update Addon Details</h5>
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

                        <form action="{{ route('admin.addons.update', $addon->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Addon Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $addon->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Price (Rs) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs</span>
                                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $addon->price) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $addon->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $addon->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Addon</button>
                            </div>
                        </form>

                    </div>
                </div>
            @endsection