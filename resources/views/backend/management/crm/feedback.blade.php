@extends('backend.layouts.app')

@section('title', 'Customer Feedback')

@section('content')
<div class="container-fluid p-0">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <h4 class="fw-bold text-dark mb-1">Customer Reviews & Feedback</h4>
            <p class="text-muted small mb-0">Monitor real-time customer satisfaction</p>
        </div>
    </div>

    {{-- Main Row --}}
    {{-- align-items-stretch is key here --}}
    <div class="row g-3 align-items-stretch">
        
        {{-- Left Side Column --}}
        <div class="col-xl-4 col-lg-5">
            <div class="d-flex flex-column h-100">
                
                {{-- 1. Average Rating Card --}}
                {{-- Removed mb-3 and replaced with small margin to keep them tight --}}
                <div class="card border-0 shadow-sm text-center p-4 mb-2" style="border-radius: 16px;">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2">Average Rating</h6>
                    @php
                        $avgRating = count($feedbacks) > 0 ? number_format($feedbacks->avg('rating'), 1) : '0.0';
                        $fullStars = floor($avgRating);
                    @endphp
                    <h1 class="display-4 fw-bold text-primary mb-1">{{ $avgRating }}</h1>
                    <div class="text-warning mb-2">
                        @for($i=1; $i<=5; $i++)
                            <i class="ti ti-star{{ $i <= $fullStars ? '-filled' : '' }} fs-4"></i>
                        @endfor
                    </div>
                    <p class="text-muted small mb-0">Total {{ count($feedbacks) }} reviews</p>
                </div>

                {{-- 2. Rating Breakdown Card --}}
                {{-- flex-grow-1 will force this card to fill all remaining vertical space --}}
                <div class="card border-0 shadow-sm p-4 flex-grow-1" style="border-radius: 16px;">
                    <h6 class="fw-bold text-dark mb-3">Rating Breakdown</h6>
                    @php $total = count($feedbacks) ?: 1; @endphp
                    
                    {{-- This container ensures bars are spaced out evenly --}}
                    <div class="d-flex flex-column justify-content-between" style="height: calc(100% - 40px);">
                        @for($s = 5; $s >= 1; $s--)
                            @php
                                $count = $feedbacks->where('rating', $s)->count();
                                $percent = ($count / $total) * 100;
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <span class="small text-muted me-2" style="min-width: 50px;">{{ $s }} Stars</span>
                                <div class="progress flex-grow-1 bg-light" style="height: 6px; border-radius: 10px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%;"></div>
                                </div>
                                <span class="small text-dark fw-bold ms-3" style="min-width: 20px;">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Feedback Table --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm h-100 d-flex flex-column" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Recent Feedback</h5>
                    <button class="btn btn-sm btn-light-secondary rounded-pill px-3">View All</button>
                </div>

                <div class="card-body p-0 flex-grow-1">
                    <div class="table-responsive h-100">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-muted small fw-bold">CUSTOMER</th>
                                    <th class="border-0 text-muted small fw-bold text-center">RATING</th>
                                    <th class="border-0 text-muted small fw-bold">MESSAGE</th>
                                    <th class="text-end pe-4 border-0 text-muted small fw-bold">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $fb)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">{{ strtoupper(substr($fb->customer->name ?? 'C', 0, 1)) }}</div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark small">{{ $fb->customer->name ?? 'Walk-in' }}</h6>
                                                <small class="text-muted" style="font-size: 10px;">{{ $fb->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light-warning text-warning rounded-pill px-2">
                                            <i class="ti ti-star-filled me-1"></i>{{ $fb->rating }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-muted small text-wrap" style="max-width: 220px;">
                                            {{ Str::limit($fb->comment, 55) }}
                                        </p>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-icon btn-light-primary me-1"><i class="ti ti-eye fs-6"></i></button>
                                        <button class="btn btn-icon btn-light-danger"><i class="ti ti-trash fs-6"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-20 mb-2">
                                            <i class="ti ti-message-off" style="font-size: 50px;"></i>
                                        </div>
                                        <p class="text-muted small">No feedback found yet.</p>
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

<style>
    /* Final Polish Styles */
    .bg-light-subtle { background-color: #fafbfc; }
    .bg-light-warning { background-color: #fff9e6; }
    
    .avatar-sm {
        width: 30px; height: 30px;
        background: #7267ef; color: #fff;
        border-radius: 8px; display: flex;
        align-items: center; justify-content: center; font-weight: bold; font-size: 11px;
    }

    .btn-icon {
        width: 30px; height: 30px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; border: none; transition: 0.2s;
    }
    
    .btn-light-primary { background: #eeecfd; color: #7267ef; }
    .btn-light-danger { background: #fff1f2; color: #ff4c51; }

    /* Force Equal Height Columns */
    .row.g-3.align-items-stretch {
        display: flex;
        flex-wrap: wrap;
    }

    /* This makes sure the cards inside the columns actually stretch */
    .col-xl-4, .col-xl-8 {
        display: flex;
        flex-direction: column;
    }
</style>
@endsection