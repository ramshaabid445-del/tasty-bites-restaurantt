@extends('backend.layouts.app')
@section('content')
<div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.deals.index') }}">Deals</a></li>
                            <li class="breadcrumb-item" aria-current="page">Create New Deal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Deal / Combo Pack</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.deals.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Deal Name (e.g. Family Feast)</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter deal name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Deal Price (Discounted)</label>
                                    <input type="number" name="price" class="form-control" placeholder="999" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Select Items Included in Deal</label>
                                    <select name="menu_items[]" class="form-control" multiple>
                                        {{-- Yahan hum Controller se items bhejenge --}}
                                        <option value="">Select Multiple Items...</option>
                                    </select>
                                    <small class="text-muted">Hold Ctrl (or Cmd) to select multiple items.</small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Create Deal</button>
                                <a href="{{ route('admin.deals.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            @endsection