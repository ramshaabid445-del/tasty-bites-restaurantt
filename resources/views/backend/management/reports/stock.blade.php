@extends('backend.layouts.app')

@section('title', 'Stock & Inventory Report')

@section('content')
<div class="container-fluid p-0">
    <style>
        /* DASHBOARD MATCHING STYLES */
        .stock-card { border-radius: 12px !important; border: none !important; box-shadow: 0 2px 12px rgba(0,0,0,0.05) !important; }
        .item-img-wrapper { width: 40px; height: 40px; background: #f0efff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #7267ef; font-weight: 600; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        
        /* Mantis Theme Colors */
        .bg-light-success { background: rgba(40, 199, 111, 0.12) !important; color: #28c76f !important; }
        .bg-light-danger { background: rgba(234, 84, 85, 0.12) !important; color: #ea5455 !important; }
        .bg-light-primary { background: rgba(114, 103, 239, 0.1) !important; color: #7267ef !important; }
        .btn-light-secondary { background: #f3f4f9; color: #5b6b79; border: none; }
        
        .table thead th { background: #f8f9fa; text-transform: uppercase; font-size: 11px; letter-spacing: 0.8px; color: #8c9097; padding: 15px; border: none; }
        .category-badge { background: #f0efff; color: #7267ef; font-size: 11px; padding: 4px 12px; border-radius: 6px; font-weight: 600; }
        
        /* Print Styles */
        @media print { 
            .no-print { display: none !important; } 
            .card { box-shadow: none !important; border: 1px solid #eee !important; }
        }
    </style>

    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold text-dark mb-1">Inventory & Stock Status</h4>
            <p class="text-muted small mb-0">Monitor your menu items stock and availability levels</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0 no-print">
            <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px; background-color: #7267ef; border:none;">
                <i class="ti ti-printer me-1"></i> Print Stock Report
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stock-card p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Total Menu Items</p>
                        {{-- 🔥 PATCH: Replaced count() with total() to prevent layout data clipping during pages shifting --}}
                        <h3 class="fw-bold mb-0 text-dark">{{ method_exists($items, 'total') ? $items->total() : $items->count() }}</h3>
                    </div>
                    <div class="bg-light-primary p-3 rounded-3">
                        <i class="ti ti-box fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stock-card p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Currently Available</p>
                        {{-- 🔥 PATCH: Dynamic safe metric filtering from total controller block data context --}}
                        <h3 class="fw-bold mb-0 text-success">{{ $total_available ?? ($items->where('status', 1)->count()) }}</h3>
                    </div>
                    <div class="bg-light-success p-3 rounded-3">
                        <i class="ti ti-circle-check fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stock-card p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small fw-bold mb-1 text-uppercase">Out of Stock</p>
                        {{-- 🔥 PATCH: Dynamic safe metric filtering from total controller block data context --}}
                        <h3 class="fw-bold mb-0 text-danger">{{ $total_out_of_stock ?? ($items->where('status', 0)->count()) }}</h3>
                    </div>
                    <div class="bg-light-danger p-3 rounded-3">
                        <i class="ti ti-alert-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Inventory Table --}}
    <div class="card stock-card overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Item Details</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th class="text-center">Stock Status</th>
                            <th class="text-end pe-4 no-print">Quick Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="item-img-wrapper me-3">
                                        {{ substr($item->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->name }}</h6>
                                        <small class="text-muted">SKU: {{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="category-badge">{{ $item->category->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rs. {{ number_format($item->price, 0) }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->status == 1)
                                    <span class="badge bg-light-success text-success rounded-pill px-3 py-2">
                                        <span class="status-dot bg-success"></span> In Stock
                                    </span>
                                @else
                                    <span class="badge bg-light-danger text-danger rounded-pill px-3 py-2">
                                        <span class="status-dot bg-danger"></span> Out of Stock
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4 no-print">
                                <div class="d-flex justify-content-end gap-1">
                                    {{-- Edit Button --}}
                                    @if(Route::has('admin.menu.items.edit'))
                                        <a href="{{ route('admin.menu.items.edit', $item->id) }}" class="btn btn-sm btn-light-primary btn-icon shadow-none" title="Edit Item">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                    @endif
                                    
                                    {{-- Status Toggle Form --}}
                                    <form action="{{ route('admin.reports.toggle-status', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-light-secondary btn-icon shadow-none" title="Switch Stock Status">
                                            <i class="ti ti-refresh fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- 🔥 ADDED: Centered Bootstrap-5 Pagination Control for sliding records table grid --}}
        @if(method_exists($items, 'links'))
            <div class="card-footer bg-transparent border-0 pt-0 pb-4 d-flex justify-content-center no-print">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection