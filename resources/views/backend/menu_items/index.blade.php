@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div class="page-header-title">
                    <h2 class="mb-0">Food Items</h2>
                </div>
                <a href="{{ route('admin.menu-items.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add New Item
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Menu Items List</h5>
                <div class="search-box">
                    <input type="text" class="form-control form-control-sm" placeholder="Search dish...">
                </div>
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
                                <th>Dish</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menuItems as $key => $item)
                            <tr>
                                <td class="ps-4 text-muted">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md overflow-hidden rounded-circle border me-3">
                                            @if($item->image)
                                                <img src="{{ asset('uploads/menu_items/'.$item->image) }}" alt="img" class="img-fluid">
                                            @else
                                                <div class="bg-light-secondary text-secondary d-flex align-items-center justify-content-center h-100">
                                                    <i class="ti ti-tools-kitchen-2 fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark fw-600">{{ $item->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light-info text-info">{{ $item->category->name ?? 'General' }}</span></td>
                                <td><span class="fw-bold text-dark">Rs {{ number_format($item->price, 0) }}</span></td>
                                <td>
                                    @if($item->status == 1)
                                        <span class="badge bg-light-success text-success">Active</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.menu-items.edit', $item->id) }}" class="btn btn-sm btn-light-primary btn-icon" title="Edit">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                        <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger btn-icon" onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="ti ti-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-3">
                                        <i class="ti ti-tools-kitchen-2 fs-1 text-muted opacity-25"></i>
                                        <p class="text-muted mt-2">No menu items found.</p>
                                    </div>
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
@endsection
