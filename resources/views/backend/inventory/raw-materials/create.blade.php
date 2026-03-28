@extends('backend.layouts.app')

@section('content')
<div class="pc-container" style="padding-top: 80px;">
    <div class="pc-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h4 class="fw-bold mb-0">Add New Ingredient</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.inventory.raw-materials.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Ingredient Name (e.g., Chicken, Rice)</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit</label>
                                    <select name="unit" class="form-select" required>
                                        <option value="kg">Kilogram (kg)</option>
                                        <option value="ltr">Liter (ltr)</option>
                                        <option value="pcs">Pieces (pcs)</option>
                                        <option value="gm">Gram (gm)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Initial Quantity</label>
                                    <input type="number" name="quantity" step="0.01" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-danger">Alert Quantity (Low stock signal)</label>
                                <input type="number" name="alert_quantity" step="0.01" class="form-control" value="5" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg shadow">Save Ingredient</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection