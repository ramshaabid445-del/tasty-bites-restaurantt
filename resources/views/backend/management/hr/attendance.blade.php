@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold text-dark">Daily Attendance</h4>
                    <button class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#markAttendanceModal">
                        <i class="ti ti-plus me-1"></i> Mark Manual Attendance
                    </button>
                </div>
                <p class="text-muted small mb-0">Track employee check-in/out times</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="alert alert-light-info border border-info border-opacity-25 d-flex align-items-center mb-4" role="alert">
                    <i class="ti ti-calendar-event fs-4 me-2 text-info"></i>
                    <div>Attendance log for <strong class="text-info">{{ date('d M, Y') }}</strong></div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">EMPLOYEE</th>
                                <th class="text-center">CHECK-IN</th>
                                <th class="text-center">CHECK-OUT</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-end pe-3">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances ?? [] as $log)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-primary rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="ti ti-user text-primary"></i>
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $log->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="text-center fw-medium text-muted">
                                    {{ $log->check_in ? date('h:i A', strtotime($log->check_in)) : '--:--' }}
                                </td>
                                <td class="text-center fw-medium text-muted">
                                    {{ $log->check_out ? date('h:i A', strtotime($log->check_out)) : '--:--' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $log->status == 'Present' ? 'bg-success' : 'bg-danger' }} text-uppercase" style="font-size: 10px;">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Check-out Button (Agar check-out nahi hua) --}}
                                        @if(!$log->check_out)
                                        <form action="{{ route('admin.attendance.checkout', $log->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-light-warning border-0" title="Check-out Now">
                                                <i class="ti ti-logout"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Delete Form --}}
                                        <form action="{{ route('admin.attendance.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Pakka delete karna hai?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger border-0"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No attendance records for today.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL FOR MARKING ATTENDANCE --}}
<div class="modal fade" id="markAttendanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Mark Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.attendance.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Employee</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Choose Employee...</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Check-in Time</label>
                            <input type="time" name="check_in" class="form-control" value="{{ date('H:i') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="Present">Present</option>
                                <option value="Late">Late</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save Attendance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .alert-light-info { background-color: #e3f2fd; color: #0d47a1; }
    .btn-light-danger { background: #fee2e2; color: #ef4444; }
    .btn-light-danger:hover { background: #ef4444; color: #fff; }
    .btn-light-warning { background: #fff3cd; color: #856404; }
    .btn-light-warning:hover { background: #ffc107; color: #000; }
    .table thead th { font-size: 11px; letter-spacing: 0.5px; color: #888; font-weight: 700; text-transform: uppercase; }
</style>
@endsection