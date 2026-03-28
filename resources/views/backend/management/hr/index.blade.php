@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div class="page-header-title">
                    <h2 class="mb-0">Staff Management</h2>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="ti ti-plus me-1"></i> Add Staff Member
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>All Staff Members</h5>
                <span class="badge bg-light-primary text-primary">{{ count($employees) }} Members</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Staff Name</th>
                                <th>Designation</th>
                                <th>Contact Details</th>
                                <th>Monthly Salary</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $emp)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle me-3">
                                            {{ substr($emp->name, 0, 1) }}
                                        </div>
                                        <h6 class="mb-0 text-dark fw-600">{{ $emp->name }}</h6>
                                    </div>
                                </td>
                                <td><span class="text-dark">{{ $emp->designation }}</span></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dark">{{ $emp->phone }}</span>
                                        <small class="text-muted">{{ $emp->email }}</small>
                                    </div>
                                </td>
                                <td><span class="fw-bold text-dark">Rs {{ number_format($emp->salary, 0) }}</span></td>
                                <td>
                                    <span class="badge bg-light-success text-success">Active</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light-primary btn-icon"><i class="ti ti-edit"></i></button>
                                        <button class="btn btn-sm btn-light-danger btn-icon"><i class="ti ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ti ti-users fs-1 opacity-25"></i>
                                    <p class="mt-2">No staff members found in the database.</p>
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

<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold fs-4">Add New Staff Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.hr.employees.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="John Doe">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Phone Number</label>
                            <input type="text" name="phone" class="form-control" required placeholder="+92 300 1234567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Designation</label>
                            <input type="text" name="designation" class="form-control" required placeholder="Chef, Waiter, etc.">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Monthly Salary</label>
                            <input type="number" name="salary" class="form-control" required placeholder="50000">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Joining Date</label>
                            <input type="date" name="joining_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Staff Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection