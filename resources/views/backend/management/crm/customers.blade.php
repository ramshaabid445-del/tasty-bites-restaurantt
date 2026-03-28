@extends('backend.layouts.app')
@section('title', 'Customer Database')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card ">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Customer Database</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                    <i class="ti ti-plus"></i> Add Customer
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Loyalty Points</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td class="ps-4"><strong>{{ $customer->name }}</strong></td>
                                <td>{{ $customer->phone ?? 'N/A' }}</td>
                                <td>{{ $customer->email ?? 'N/A' }}</td>
                                <td><span class="badge bg-light-warning text-warning">{{ $customer->loyalty_points }} pts</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-icon btn-light-info"><i class="ti ti-edit"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4">No customers found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endsection