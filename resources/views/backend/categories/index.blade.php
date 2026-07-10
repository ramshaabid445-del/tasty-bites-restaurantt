@extends('backend.layouts.app')

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
        <div class="card shadow-sm border-0">
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
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">#</th>
                                <th style="width: 100px;">Image</th>
                                <th>Category Name</th>
                                <th style="width: 150px;">Status</th>
                                <th class="text-end pe-4" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $key => $category)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $key + 1 }}</td>
                                <td>
                                    @if($category->image)
                                        {{-- Fixed Height and Width for Image Container --}}
                                        <div class="avatar border" style="width: 45px; height: 45px; overflow: hidden; border-radius: 8px;">
                                            <img src="{{ asset('uploads/categories/'.$category->image) }}" 
                                                 alt="img" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="avatar bg-light-secondary text-secondary d-flex align-items-center justify-content-center" 
                                             style="width: 45px; height: 45px; border-radius: 8px;">
                                            <i class="ti ti-photo fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <h6 class="mb-0 text-dark fw-600">{{ $category->name }}</h6>
                                </td>
                                <td>
                                    @if($category->status == 1)
                                        <span class="badge bg-light-success text-success px-3">Active</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger px-3">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                           class="btn btn-sm btn-light-primary btn-icon border-0" 
                                           title="Edit">
                                            <i class="ti ti-edit fs-5"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-light-danger btn-icon border-0" 
                                                    onclick="return confirm('Are you sure you want to delete this category?')" 
                                                    title="Delete">
                                                <i class="ti ti-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="ti ti-category fs-1 text-muted opacity-25"></i>
                                        <p class="text-muted mt-2 mb-0">No categories found in the records.</p>
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

<style>
    /* Taake text zyada bada na lage aur alignment set rahe */
    .fw-600 { font-weight: 600; }
    .table > :not(caption) > * > * {
        padding: 12px 8px; /* Standard row padding */
    }
    .avatar img {
        display: block;
    }
</style>
@endsection