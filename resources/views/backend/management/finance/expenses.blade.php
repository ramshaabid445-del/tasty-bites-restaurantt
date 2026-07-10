@extends('backend.layouts.app')

@section('title', 'Expense Tracker')

@section('content')
<div class="container-fluid p-0">
    {{-- 1. Header Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-sm-6">
            <h4 class="fw-bold text-dark mb-1">Expense Tracker</h4>
            <p class="text-muted small mb-0">Manage and monitor your business outgoings</p>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            <button class="btn btn-primary shadow-sm px-4 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                <i class="ti ti-plus me-1"></i> Record New Expense
            </button>
        </div>
    </div>

    {{-- 2. Stats Summary Widgets --}}
    <div class="row g-4 mb-4 d-flex align-items-stretch">
        <div class="col-xl-4 col-md-6">
            {{-- FORCED VISIBILITY PURPLE CARD --}}
            <div style="background: linear-gradient(135deg, #7267ef 0%, #9e8cf1 100%) !important; 
                        border-radius: 16px !important; 
                        padding: 1.5rem !important; 
                        position: relative !important; 
                        overflow: hidden !important;
                        min-height: 120px !important;
                        height: 100% !important;
                        display: flex !important;
                        flex-direction: column !important;
                        justify-content: center !important;
                        box-shadow: 0 4px 12px rgba(114, 103, 239, 0.15) !important;">
                
                <i class="ti ti-receipt" style="position: absolute !important; right: -10px !important; bottom: -10px !important; font-size: 80px !important; color: white !important; opacity: 0.15 !important;"></i>
                
                <div style="position: relative !important; z-index: 2 !important;">
                    <p style="color: rgba(255,255,255,0.8) !important; margin-bottom: 5px !important; font-size: 0.85rem !important; font-weight: 500 !important; text-transform: uppercase; letter-spacing: 0.5px;">Total Monthly Expense</p>
                    {{-- 🔥 PATCH: Changed hardcoded Rs. 45,000 to dynamic operational database metric calculations --}}
                    <h2 style="color: white !important; font-weight: 800 !important; margin-bottom: 0 !important;">Rs. {{ number_format($total_expenses ?? 0) }} <small style="font-size: 0.8rem !important; opacity: 0.6 !important;">PKR</small></h2>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: #fff;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-light-info p-3 rounded-circle text-info me-3 shadow-sm">
                        <div class="d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                            <i class="ti ti-clock-pause fs-3"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold text-uppercase">Total Records Found</p>
                        {{-- 🔥 PATCH: Changed hardcoded '03' to dynamic actual table row logs index count --}}
                        <h4 class="fw-bold mb-0 text-dark">{{ sprintf("%02d", $expenses->total() ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Expenses Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #fff;">
        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="fw-bold text-dark mb-0">Expense History</h5>
            <div class="dropdown">
                <button class="btn btn-light-secondary btn-sm rounded-pill px-4 fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Filter Category
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bold">DATE</th>
                            <th class="border-0 text-muted small fw-bold">DESCRIPTION</th>
                            <th class="text-center border-0 text-muted small fw-bold">CATEGORY</th>
                            <th class="text-end pe-4 border-0 text-muted small fw-bold">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses ?? [] as $exp)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="text-dark fw-medium">{{ \Carbon\Carbon::parse($exp->expense_date)->format('d M, Y') }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-bold">{{ $exp->title }}</span>
                                    <small class="text-muted">Ref: #{{ 1000 + $exp->id }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light-primary text-primary px-3 py-2 border-0 fw-bold" style="font-size: 10px;">
                                    {{ strtoupper($exp->category ?? 'General') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="fw-bold text-dark">Rs. {{ number_format($exp->amount) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted opacity-25 mb-3">
                                    <i class="ti ti-package-off" style="font-size: 60px;"></i>
                                </div>
                                <h6 class="text-muted fw-normal">No expense records found.</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- 🔥 ADDED: Centered Bootstrap-5 Pagination Controls for safe data shifting --}}
        <div class="card-footer bg-transparent border-0 pt-0 pb-4 d-flex justify-content-center">
            {{ $expenses->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- 4. Modal Section --}}
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold text-dark">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.finance.expenses') }}" method="POST">
                @csrf
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Title</label>
                        <input type="text" name="title" class="form-control border-0 bg-light p-3 rounded-3" placeholder="e.g. Monthly Rent" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Amount</label>
                            <input type="number" name="amount" class="form-control border-0 bg-light p-3 rounded-3" placeholder="0" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Date</label>
                            <input type="date" name="expense_date" class="form-control border-0 bg-light p-3 rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                        <select name="category" class="form-select border-0 bg-light p-3 rounded-3">
                            <option value="General">General</option>
                            <option value="Utilities">Utilities</option>
                            <option value="Rent">Rent</option>
                            <option value="Staff Salaries">Staff Salaries</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-light-subtle { background-color: #fcfcfd; }
    .bg-light-primary { background: rgba(114, 103, 239, 0.1); color: #7267ef; }
    .bg-light-info { background: rgba(63, 179, 237, 0.1); color: #3fb3ed; }
    .btn-light-secondary { background: #f3f4f9; color: #5b6b79; border: none; }
    .table thead th { border-bottom: 1px solid #f0f0f0 !important; font-size: 11px; letter-spacing: 0.8px; }
    .card { border: none !important; }
</style>
@endsection