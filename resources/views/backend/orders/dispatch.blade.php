@extends('backend.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Order Dispatch / Handover</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Orders Ready for Dispatch</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer/Table</th>
                                        <th>Order Type</th>
                                        <th>Status</th>
                                        <th>Assign To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>#ORD-00098</strong></td>
                                        <td>Table 02</td>
                                        <td><span class="badge bg-light-primary">Dine-in</span></td>
                                        <td><span class="badge bg-success">Ready to Serve</span></td>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option>Select Waiter</option>
                                                <option>Ali</option>
                                                <option>Ahmed</option>
                                            </select>
                                        </td>
                                        <td><button class="btn btn-sm btn-primary">Dispatch</button></td>
                                    </tr>
                                    <tr>
                                        <td><strong>#ORD-00099</strong></td>
                                        <td>John Doe (0300-1234567)</td>
                                        <td><span class="badge bg-light-info">Delivery</span></td>
                                        <td><span class="badge bg-success">Packed</span></td>
                                        <td>
                                            <select class="form-select form-select-sm">
                                                <option>Select Rider</option>
                                                <option>FoodPanda Rider</option>
                                                <option>Own Rider - Usman</option>
                                            </select>
                                        </td>
                                        <td><button class="btn btn-sm btn-primary">Handover</button></td>
                                    </tr>
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