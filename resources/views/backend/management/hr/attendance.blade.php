@extends('backend.layouts.app')
@section('content')
<div class="pc-container">
    <div class="pc-content">
        <h5>Daily Attendance</h5>
        <div class="card mt-3">
            <div class="card-body">
                <div class="alert alert-info">Attendance log for {{ date('d M, Y') }}</div>
                <table class="table table-striped">
                    <thead><tr><th>Employee</th><th>Check-in</th><th>Check-out</th><th>Status</th></tr></thead>
                    <tbody>
                        <tr><td>Ali Ahmed</td><td>09:00 AM</td><td>--:--</td><td><span class="badge bg-success">Present</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection