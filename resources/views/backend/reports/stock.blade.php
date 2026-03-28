@extends('backend.layouts.app')

@section('content')
<div class="pc-container" style="padding-top: 80px; background: #f8f9fa;">
    <div class="pc-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">📦 Stock & Inventory</h2>
                <p class="text-muted">Current Menu Item Availability</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.menu-items.index') }}" class="btn btn-primary shadow-sm"><i class="ti ti-settings me-1"></i> Manage Menu</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small">
                                    <tr>
                                        <th class="ps-4">Item Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th class="pe-4">Current Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $item->name }}</td>
                                        <td><span class="text-muted">{{ $item->category->name ?? 'N/A' }}</span></td>
                                        <td class="fw-bold">Rs {{ number_format($item->price) }}</td>
                                        <td class="pe-4">
                                            @if($item->status == 1)
                                                <span class="badge bg-light-success text-success px-3">Available</span>
                                            @else
                                                <span class="badge bg-light-danger text-danger px-3">Out of Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection