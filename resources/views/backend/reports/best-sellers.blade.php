@extends('backend.layouts.app')

@section('content')
<div class="pc-container" style="padding-top: 80px; background: #f8f9fa;">
    <div class="pc-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark">🔥 Best Sellers Report</h2>
                <p class="text-muted">Analysis of top performing menu items</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button onclick="window.print()" class="btn btn-secondary shadow-sm"><i class="ti ti-printer me-1"></i> Print</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Item Performance Ranking</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small">
                                    <tr>
                                        <th class="ps-4">Rank</th>
                                        <th>Item Name</th>
                                        <th class="text-center">Units Sold</th>
                                        <th class="text-end pe-4">Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bestSellers as $index => $item)
                                    <tr>
                                        <td class="ps-4 fw-bold">#{{ $index + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $item->item_name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light-primary text-primary px-3 py-2 fs-6" style="border-radius: 10px;">
                                                {{ $item->qty }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 fw-bold text-success">Rs {{ number_format($item->amount) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection