@extends('backend.layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Restaurant Floor Plan</h2>
                        <div>
                            <span class="badge bg-light-success text-success me-2">● Available</span>
                            <span class="badge bg-light-danger text-danger me-2">● Occupied</span>
                            <span class="badge bg-light-warning text-warning">● Reserved</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @forelse($tables as $table)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card  h-100 text-center">
                    <div class="card-body">
                        <div class="mb-3">
                            @if($table->status == 'available')
                                <i class="ti ti-armchair fs-1 text-success"></i>
                            @elseif($table->status == 'occupied')
                                <i class="ti ti-armchair fs-1 text-danger"></i>
                            @else
                                <i class="ti ti-armchair fs-1 text-warning"></i>
                            @endif
                        </div>

                        <h5 class="card-title mb-1">{{ $table->name }}</h5>
                        <p class="text-muted small mb-2">Capacity: {{ $table->capacity }} Persons</p>

                        <div class="mt-auto">
                            @if($table->status == 'available')
                                <span class="badge bg-success w-100">Free</span>
                            @elseif($table->status == 'occupied')
                                <span class="badge bg-danger w-100">In Use</span>
                            @else
                                <span class="badge bg-warning w-100 text-dark">Reserved</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i> No tables found. Please add tables in <strong>Table Management</strong> first.
                </div>
            </div>
        @endforelse
    </div>
@endsection
