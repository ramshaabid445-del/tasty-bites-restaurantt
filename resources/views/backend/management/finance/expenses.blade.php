@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12 d-flex justify-content-between">
                        <h5>Expense Tracker</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            <i class="ti ti-receipt me-1"></i> Record New Expense
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="card bg-light-danger">
                    <div class="card-body">
                        <h6>Total Expenses (This Month)</h6>
                        <h4>Rs. 45,000</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $exp)
                        <tr>
                            <td>{{ $exp->expense_date }}</td>
                            <td>{{ $exp->title }}</td>
                            <td>{{ $exp->category ?? 'General' }}</td>
                            <td class="text-danger">Rs. {{ number_format($exp->amount) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No expenses recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5>Add Expense</h5></div>
            <form action="{{ route('admin.finance.expenses') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="text" name="title" class="form-control mb-2" placeholder="Title (e.g. Electricity Bill)" required>
                    <input type="number" name="amount" class="form-control mb-2" placeholder="Amount" required>
                    <input type="date" name="expense_date" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection