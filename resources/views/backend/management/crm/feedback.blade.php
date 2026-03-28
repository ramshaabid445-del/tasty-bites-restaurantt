@extends('backend.layouts.app')
@section('title', 'Customer Feedback')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Recent Reviews & Feedback</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Customer</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Ye data hum Controller se pass karenge --}}
                            @forelse($feedbacks as $fb)
                            <tr>
                                <td class="ps-4"><strong>{{ $fb->customer->name }}</strong></td>
                                <td>
                                    @for($i=1; $i<=5; $i++)
                                        <i class="ti ti-star{{ $i <= $fb->rating ? '-filled text-warning' : ' text-muted' }}"></i>
                                    @endfor
                                </td>
                                <td>{{ Str::limit($fb->comment, 50) }}</td>
                                <td>{{ $fb->created_at->format('d M, Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No reviews yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection