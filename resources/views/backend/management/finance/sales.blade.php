@extends('backend.layouts.app')
@section('content')
<div class="card ">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0 text-white">Total Sales: {{ number_format($total_sales, 2) }}</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->customer_name ?? 'Guest' }}</td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                    <td><span class="badge bg-success">Paid</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endsection