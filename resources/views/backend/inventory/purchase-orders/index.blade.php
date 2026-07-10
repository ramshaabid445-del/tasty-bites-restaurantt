@extends('backend.layouts.app')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 fw-bold">Purchase Orders</h2>
                        <a href="{{ route('admin.inventory.purchase-orders.create') }}" class="btn btn-primary shadow-sm">
                            <i class="ti ti-plus me-1"></i> Create New PO
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dom-jqry" class="table table-hover align-middle border-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-muted small fw-bold">Sl</th>
                                    <th class="text-muted small fw-bold">PO Number</th>
                                    <th class="text-muted small fw-bold">Supplier</th>
                                    <th class="text-muted small fw-bold">Order Date</th>
                                    <th class="text-muted small fw-bold">Total Amount</th>
                                    <th class="text-muted small fw-bold">Status</th>
                                    <th class="text-muted small fw-bold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key => $order)
                                <tr>
                                    <td><span class="text-muted">{{ $key+1 }}</span></td>
                                    <td><span class="fw-bold text-dark">{{ $order->po_number }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <span class="avatar-title rounded-circle bg-light text-primary small">
                                                    {{ substr($order['supplier']['name'] ?? 'N', 0, 1) }}
                                                </span>
                                            </div>
                                            {{ $order['supplier']['name'] ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                                    <td class="fw-bold text-dark">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($order->status);
                                            $badgeClass = 'bg-light-secondary text-secondary';
                                            if($status == 'pending') $badgeClass = 'bg-light-warning text-warning';
                                            elseif($status == 'received') $badgeClass = 'bg-light-success text-success';
                                            elseif($status == 'cancelled') $badgeClass = 'bg-light-danger text-danger';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} border-0 px-3">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.inventory.purchase-orders.show', $order->id) }}" 
                                               class="btn btn-sm btn-light-primary border-0" 
                                               data-bs-toggle="tooltip" title="View Details">
                                                <i class="ti ti-eye fs-5"></i>
                                            </a>
                                            
                                            <a href="{{ route('admin.inventory.purchase-orders.edit', $order->id) }}" 
                                               class="btn btn-sm btn-light-info border-0" 
                                               data-bs-toggle="tooltip" title="Edit Order">
                                                <i class="ti ti-edit fs-5"></i>
                                            </a>

                                            <form action="{{ route('admin.inventory.purchase-orders.destroy', $order->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this PO?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger border-0" data-bs-toggle="tooltip" title="Delete PO">
                                                    <i class="ti ti-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
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
@endsection