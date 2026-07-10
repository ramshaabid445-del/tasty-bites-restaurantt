@extends('backend.layouts.app')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark"> Inventory & Availability</h2>
        <p class="text-muted">Monitor your menu items stock and availability levels</p>
    </div>
</div>

<div class="card shadow-sm border-0" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small">
                    <tr>
                        <th class="ps-4">Item Details</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="pe-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark d-block">{{ $item->name }}</span>
                            <small class="text-muted">ID: #{{ $item->id }}</small>
                        </td>
                        <td><span class="badge bg-light-info text-info">{{ $item->category->name ?? 'General' }}</span></td>
                        <td class="fw-bold">Rs. {{ number_format($item->price) }}</td>
                        <td>
                            @if($item->status == 1)
                                <span class="badge bg-light-success text-success px-3">In Stock</span>
                            @else
                                <span class="badge bg-light-danger text-danger px-3">Out of Stock</span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            <form action="{{ route('admin.reports.toggle-status', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light border shadow-none">
                                    <i class="ti {{ $item->status == 1 ? 'ti-eye text-primary' : 'ti-eye-off text-muted' }} fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection@extends('backend.layouts.app')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold text-dark"> Inventory & Availability</h2>
        <p class="text-muted">Monitor your menu items stock and availability levels</p>
    </div>
    <div class="col-md-6 text-md-end">
        <button class="btn btn-primary shadow-sm"><i class="ti ti-printer me-1"></i> Print Stock Report</button>
    </div>
</div>

{{-- Top Summary Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <p class="text-uppercase small fw-bold text-muted mb-1">Total Menu Items</p>
                    <h3 class="mb-0">{{ count($items) }}</h3>
                </div>
                <div class="bg-light-primary p-3 rounded"><i class="ti ti-box fs-3 text-primary"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <p class="text-uppercase small fw-bold text-muted mb-1">Currently Available</p>
                    <h3 class="mb-0 text-success">{{ $items->where('status', 1)->count() }}</h3>
                </div>
                <div class="bg-light-success p-3 rounded"><i class="ti ti-circle-check fs-3 text-success"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <p class="text-uppercase small fw-bold text-muted mb-1">Out of Stock</p>
                    <h3 class="mb-0 text-danger">{{ $items->where('status', 0)->count() }}</h3>
                </div>
                <div class="bg-light-danger p-3 rounded"><i class="ti ti-alert-circle fs-3 text-danger"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Main Inventory Table --}}
<div class="card shadow-sm border-0" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="font-size: 0.75rem; color: #adb5bd;">ITEM DETAILS</th>
                        <th class="py-3" style="font-size: 0.75rem; color: #adb5bd;">CATEGORY</th>
                        <th class="py-3" style="font-size: 0.75rem; color: #adb5bd;">PRICE</th>
                        <th class="py-3" style="font-size: 0.75rem; color: #adb5bd;">CURRENT STATUS</th>
                        <th class="pe-4 py-3 text-center" style="font-size: 0.75rem; color: #adb5bd;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">{{ strtoupper($item->name) }}</span>
                            <small class="text-muted">ID: #INV-{{ $item->id }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light-info text-info text-uppercase" style="font-size: 0.7rem;">
                                {{ $item->category->name ?? 'GENERAL' }}
                            </span>
                        </td>
                        <td class="fw-bold text-dark">Rs. {{ number_format($item->price) }}</td>
                        <td>
                            @if($item->status == 1)
                                <span class="badge bg-light-success text-success px-3" style="border-radius: 50px;">
                                    <i class="ti ti-circle-filled me-1" style="font-size: 8px;"></i> In Stock
                                </span>
                            @else
                                <span class="badge bg-light-danger text-danger px-3" style="border-radius: 50px;">
                                    <i class="ti ti-circle-filled me-1" style="font-size: 8px;"></i> Out of Stock
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            {{-- Important: Toggle Form --}}
                            <form action="{{ route('admin.reports.toggle-status', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light border-0 shadow-none p-2" title="Change Visibility">
                                    <i class="ti {{ $item->status == 1 ? 'ti-eye text-primary' : 'ti-eye-off text-muted' }} fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection