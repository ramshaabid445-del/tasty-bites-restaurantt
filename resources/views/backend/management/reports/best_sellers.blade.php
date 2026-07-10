@extends('backend.layouts.app')

@section('title', 'Best Selling Items')

@section('content')
<div class="container-fluid p-0">
    {{-- Inline CSS for Instant Fix --}}
    <style>
        .custom-card { border-radius: 16px !important; border: none !important; box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important; background: #fff; }
        .hero-card { background: linear-gradient(45deg, #7267ef, #9e8cf1); border-radius: 16px; padding: 25px; color: white; margin-bottom: 25px; }
        .rank-box { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: bold; font-size: 13px; }
        .gold { background: #fff8e1; color: #ffc107; border: 1px solid #ffe082; }
        .silver { background: #f5f5f5; color: #9e9e9e; border: 1px solid #e0e0e0; }
        .bronze { background: #efebe9; color: #795548; border: 1px solid #d7ccc8; }
        .normal { background: #f8f9fe; color: #8c9097; }
        .item-icon { width: 40px; height: 40px; background: #f0efff; color: #7267ef; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 12px; }
        .table thead th { background: #fcfdfe; color: #8c9097; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px; border: none; }
        .table tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f3f3f3; }
    </style>

    <div class="hero-card shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="fw-bold mb-1">Product Leaderboard</h4>
                <p class="mb-0 opacity-75 small">Top performing menu items based on sales</p>
            </div>
            <i class="ti ti-trending-up fs-1 opacity-25"></i>
        </div>
    </div>

    <div class="card custom-card">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-0 text-dark">Top 10 Selling Items</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Rank</th>
                            <th>Product Name</th>
                            <th class="text-center">Qty Sold</th>
                            <th>Total Revenue</th>
                            <th class="pe-4">Popularity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $max_qty = $bestSellers->max('qty') ?? 1; @endphp
                        @forelse($bestSellers as $index => $item)
                        @php 
                            $rank = $index + 1;
                            $percent = ($item->qty / $max_qty) * 100;
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="rank-box {{ $rank==1?'gold':($rank==2?'silver':($rank==3?'bronze':'normal')) }}">
                                    {{ $rank }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="item-icon">{{ substr($item->item_name, 0, 1) }}</div>
                                    <span class="fw-bold text-dark">{{ $item->item_name }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light-primary text-primary px-3 py-2 rounded-pill fw-bold">
                                    {{ number_format($item->qty) }}
                                </span>
                            </td>
                            <td><span class="fw-bold">Rs. {{ number_format($item->amount, 2) }}</span></td>
                            <td class="pe-4">
                                <div class="progress" style="height: 6px; border-radius: 10px; width: 100px; background: #f0f0f0;">
                                    <div class="progress-bar bg-primary rounded-pill" style="width: {{ $percent }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted small">No data recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection