@extends('backend.layouts.app')

@section('title', 'Raw Materials')

@section('content')
{{-- 
    Bhai yaad rakhna: pc-container aur pc-content yahan nahi likhna 
    kyunki wo app.blade.php mein pehle se mojood hain. 
--}}

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark">Raw Materials</h2>
        <p class="text-muted">Manage your kitchen ingredients and stock levels.</p>
    </div>
    <a href="{{ route('admin.inventory.raw-materials.create') }}" class="btn btn-primary shadow-sm">+ Add Ingredient</a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small">
                    <tr>
                        <th class="ps-4">Ingredient Name</th>
                        <th>Current Stock</th>
                        <th>Unit</th>
                        <th>Alert Level</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $item)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $item->name }}</td>
                        <td class="fw-bold {{ $item->quantity <= $item->alert_quantity ? 'text-danger' : 'text-success' }}">
                            {{ $item->quantity }}
                        </td>
                        <td><span class="badge bg-light-secondary text-dark border">{{ $item->unit }}</span></td>
                        <td class="text-muted">{{ $item->alert_quantity }}</td>
                        <td class="text-center">
                            @if($item->quantity <= $item->alert_quantity)
                                <span class="badge bg-light-danger text-danger">Low Stock</span>
                            @else
                                <span class="badge bg-light-success text-success">In Stock</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <a href="#" class="btn btn-sm btn-outline-info"><i class="ti ti-edit"></i></a>
                            <form action="#" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="ti ti-package-off fs-1"></i>
                                <p class="mt-2">No items found. Start adding your ingredients!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection