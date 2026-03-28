@extends('backend.layouts.app')

@section('title', 'Roles & Permissions')

@section('content')
<div id="pc-sidebar-caption" style="display:none;"></div>
<div id="pc-layout-config" style="display:none;"></div>
<div id="pc-layout-font" style="display:none;"></div>

<div class="row">
    <div class="col-sm-12">
        <div class="card ">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">System Roles</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="ti ti-plus me-1"></i> Add New Role
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Role Name</th>
                                <th>Permissions</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avtar avtar-s bg-light-primary text-primary me-2">
                                            <i class="ti ti-shield-check"></i>
                                        </div>
                                        <strong>{{ is_string($role) ? $role : $role->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    @if(isset($role->permissions) && count($role->permissions) > 0)
                                        @foreach($role->permissions as $perm)
                                            <span class="badge bg-light-primary text-primary border border-primary mb-1">{{ $perm->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-light-success text-success border border-success">Full Access</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-icon btn-light-info me-1" title="Edit"><i class="ti ti-edit"></i></button>
                                    <button class="btn btn-sm btn-icon btn-light-danger" title="Delete"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">No roles found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('admin.hr.roles.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="addRoleModalLabel">Create New System Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Kitchen Manager" required>
                    </div>
                    
                    <h6 class="mb-3">Assign Permissions</h6>
                    <div class="row g-3">
                        {{-- All Permissions from Database --}}
                        @isset($all_permissions)
                            @foreach($all_permissions as $perm)
                            <div class="col-md-4">
                                <div class="form-check card p-2 border-light ">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}">
                                    <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        @else
                            {{-- Fallback agar database khali ho --}}
                            <div class="col-12 text-center py-2">
                                <p class="text-muted small">Run Seeder to load permissions.</p>
                            </div>
                        @endisset
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-link-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary shadow">Save Role</button>
                </div>
            </form>
        </div>
    @endsection