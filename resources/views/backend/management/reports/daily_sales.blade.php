@extends('backend.layouts.app')
@section('content')
<div class="card ">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daily Sales Report (EOD)</h5>
        <span class="badge bg-light-primary text-primary">{{ date('d M, Y') }}</span>
    </div>
    <div class="card-body">
        <h3>Total Revenue: {{ number_format($total_revenue, 2) }}</h3>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Time</th>
                    <th>Amount</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('h:i A') }}</td>
                    <td>{{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->payment_method }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endsection