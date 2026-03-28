@extends('backend.layouts.app')

@section('title', 'Suppliers / Vendors')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark">Suppliers / Vendors</h2>
        <p class="text-muted">Manage your wholesale partners and vendors.</p>
    </div>
    <a href="{{ route('admin.inventory.suppliers.create') }}" class="btn btn-primary shadow-sm">+ Add New Supplier</a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small">
                    <tr>
                        <th class="ps-4">Supplier / Company</th>
                        <th>Contact info</th>
                        <th>Opening Balance</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $supplier->name }}</div>
                            <small class="text-muted">{{ $supplier->company_name ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <div>{{ $supplier->phone }}</div>
                            <small class="text-muted">{{ $supplier->email ?? 'No Email' }}</small>
                        </td>
                        <td><span class="fw-bold">Rs. {{ number_format($supplier->opening_balance, 2) }}</span></td>
                        <td class="text-center">
                            <span class="badge {{ $supplier->status ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }}">
                                {{ $supplier->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-sm btn-outline-info"><i class="ti ti-edit"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No suppliers found. Click the button to add one!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection