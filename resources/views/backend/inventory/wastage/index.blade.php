@extends('backend.layouts.app')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Wastage Log</h2>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportWastage">
                            <i class="ti ti-trash me-1"></i> Report New Wastage
                        </button>
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
                                    <th>Date</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Reason</th>
                                    <th>Reported By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wastages as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->created_at->format('d M, Y') }}</td>
                                    <td>{{ $item['raw_material']['name'] ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td><span class="badge bg-light-danger text-danger">{{ $item->reason }}</span></td>
                                    <td>{{ $item['user']['name'] ?? 'Admin' }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-light-danger"><i class="ti ti-trash"></i></a>
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

<div class="modal fade" id="reportWastage" tabindex="-1" role="dialog" aria-labelledby="reportWastageLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportWastageLabel">Report Item Wastage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.inventory.wastage.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Select Raw Material</label>
                        <select name="raw_material_id" class="form-select" required>
                            <option value="" selected disabled>Select Item</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" step="0.01" class="form-control" placeholder="Enter quantity" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Reason</label>
                        <select name="reason" class="form-select" required>
                            <option value="Expired">Expired</option>
                            <option value="Damaged">Damaged</option>
                            <option value="Spilled">Spilled/Dropped</option>
                            <option value="Kitchen Mistake">Kitchen Mistake</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Remarks (Optional)</label>
                        <textarea name="remarks" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Save Report</button>
                </div>
            </form>
        @endsection
