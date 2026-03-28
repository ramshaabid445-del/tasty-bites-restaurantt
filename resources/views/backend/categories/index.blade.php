@extends('backend.layouts.app')
{{-- Note: Agar aapki master file ka naam kuch aur hai (jaise master, admin, etc.) toh upar wali line update kar lena --}}

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div class="page-header-title">
                    <h2 class="mb-0">Menu Categories</h2>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add New Category
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>All Categories</h5>
                <div class="search-box">
                    <input type="text" class="form-control form-control-sm" placeholder="Search...">
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
                                <th>Image</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $key => $category)
                            <tr>
                                <td class="ps-4">{{ $key + 1 }}</td>
                                <td>
                                    @if($category->image)
                                        <div class="avatar avatar-sm overflow-hidden rounded-circle border">
                                            <img src="{{ asset('uploads/categories/'.$category->image) }}" alt="img" class="img-fluid">
                                        </div>
                                    @else
                                        <div class="avatar avatar-sm bg-light-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ti ti-photo fs-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><h6 class="mb-0 text-dark fw-600">{{ $category->name }}</h6></td>
                                <td>
                                    @if($category->status == 1)
                                        <span class="badge bg-light-success text-success">Active</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-light-primary btn-icon" title="Edit">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
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
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-3">
                                        <i class="ti ti-category fs-1 text-muted opacity-25"></i>
                                        <p class="text-muted mt-2">No categories found.</p>
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
