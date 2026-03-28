@extends('backend.layouts.app')
@section('content')
<div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12 d-flex justify-content-between">
                        <h5>Deals & Combos Management</h5>
                        <a href="{{ route('admin.deals.create') }}" class="btn btn-primary btn-sm">+ Add New Deal</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Deal Name</th>
                                        <th>Price</th>
                                        <th>Items Included</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">No deals found. Start by creating one!</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endsection