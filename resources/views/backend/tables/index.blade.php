@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div class="page-header-title">
                    <h2 class="mb-0">Table Management</h2>
                </div>
                <a href="{{ route('admin.tables.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add New Table
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>All Tables</h5>
            </div>
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success m-3 alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Table Name</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tables as $key => $table)
                            <tr>
                                <td class="ps-4 text-muted">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle me-3">
                                            <i class="ti ti-table fs-5"></i>
                                        </div>
                                        <h6 class="mb-0 text-dark fw-600">{{ $table->name }}</h6>
                                    </div>
                                </td>
                                <td><span class="text-dark fw-500">{{ $table->capacity }} Persons</span></td>
                                <td>
                                    @if($table->status == 'available')
                                        <span class="badge bg-light-success text-success"><i class="ti ti-check me-1"></i>Available</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger"><i class="ti ti-user-x me-1"></i>Occupied</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.tables.edit', $table->id) }}" class="btn btn-sm btn-light-primary btn-icon">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                        <form action="{{ route('admin.tables.destroy', $table->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger btn-icon" onclick="return confirm('Are you sure?')">
                                                <i class="ti ti-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No tables found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
