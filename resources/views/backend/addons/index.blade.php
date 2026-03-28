@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center mb-3">
                    <div class="col-md-12">
                        <div class="page-header-title d-flex justify-content-between align-items-center">
                            <h5 class="m-b-10">Addons List</h5>
                            <a href="{{ route('admin.addons.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Add New Addon
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Addon Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($addons as $key => $addon)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="fw-bold">{{ $addon->name }}</td>
                                            <td>Rs {{ number_format($addon->price, 2) }}</td>
                                            <td>
                                                @if($addon->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.addons.edit', $addon->id) }}" class="btn btn-sm btn-light-primary me-1">
                                                    <i class="ti ti-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.addons.destroy', $addon->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this addon?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light-danger">
                                                        <i class="ti ti-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                No addons found. Click "Add New Addon" to create one.
                                            </td>
                                        </tr>
                                    @endforelse
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