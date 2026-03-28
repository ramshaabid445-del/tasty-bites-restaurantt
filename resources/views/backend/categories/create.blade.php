@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center mb-3">
                    <div class="col-md-12">
                        <div class="page-header-title d-flex justify-content-between align-items-center">
                            <h5 class="m-b-10">Add New Category</h5>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Back to Categories
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header border-bottom bg-light">
                        <h5 class="mb-0">Category Details</h5>
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

                        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g., Fast Food, Beverages" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Description <span class="text-muted">(Optional)</span></label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Brief details about this category">{{ old('description') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Category Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="text-muted mt-1 d-block">Recommended size: 400x400px (JPG, PNG)</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="text-end">
                                <button type="reset" class="btn btn-light me-2">Clear</button>
                                <button type="submit" class="btn btn-primary">Save Category</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection