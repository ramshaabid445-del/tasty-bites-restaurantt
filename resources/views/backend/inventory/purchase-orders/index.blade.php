@extends('backend.layouts.app')
@section('content')

<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Purchase Orders</h2>
                        <a href="{{ route('admin.inventory.purchase-orders.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Create New PO
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>PO Number</th>
                                    <th>Supplier</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><strong>{{ $order->po_number }}</strong></td>
                                    <td>{{ $order['supplier']['name'] ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                                    <td>{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @if($order->status == 'Pending')
                                            <span class="badge bg-light-warning text-warning">Pending</span>
                                        @elseif($order->status == 'Received')
                                            <span class="badge bg-light-success text-success">Received</span>
                                        @else
                                            <span class="badge bg-light-secondary text-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.inventory.purchase-orders.show', $order->id) }}" class="btn btn-sm btn-light-primary"><i class="ti ti-eye"></i></a>
                                        <a href="{{ route('admin.inventory.purchase-orders.edit', $order->id) }}" class="btn btn-sm btn-light-info"><i class="ti ti-edit"></i></a>
                                    </td>
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

@endsection