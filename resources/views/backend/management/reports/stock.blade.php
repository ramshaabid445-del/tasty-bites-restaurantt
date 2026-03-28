@extends('backend.layouts.app')
@section('title', 'Stock & Inventory Report')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="ti ti-box text-primary me-2"></i>Menu Items Availability</h5>
                <button onclick="window.print()" class="btn btn-sm btn-light-secondary"><i class="ti ti-printer"></i> Print Report</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Item Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset($item->image ?? 'assets/images/no-image.png') }}" alt="" class="img-radius" style="width:35px; height:35px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">{{ $item->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>
                                    @if($item->is_available)
                                        <span class="badge bg-light-success text-success"><i class="ti ti-check me-1"></i>In Stock</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger"><i class="ti ti-x me-1"></i>Out of Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No menu items found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection