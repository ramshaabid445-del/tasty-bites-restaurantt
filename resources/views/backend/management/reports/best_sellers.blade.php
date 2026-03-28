@extends('backend.layouts.app')
@section('title', 'Best Selling Items')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card ">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="ti ti-medal text-warning me-2"></i>Top 10 Best Selling Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Item Name</th>
                                <th>Quantity Sold</th>
                                <th>Total Revenue</th>
                                <th style="width: 30%;">Popularity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $max_qty = $bestSellers->max('qty') ?? 1; @endphp
                            @forelse($bestSellers as $item)
                            <tr>
                                <td class="ps-4"><strong>{{ $item->item_name }}</strong></td>
                                <td><span class="badge bg-light-primary text-primary">{{ number_format($item->qty) }} Units</span></td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>
                                    @php $percentage = ($item->qty / $max_qty) * 100; @endphp
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No sales data available yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endsection