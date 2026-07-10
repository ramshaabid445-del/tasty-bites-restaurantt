@extends('backend.layouts.app')

{{-- Clean tab title matching order configurations layout --}}
@section('title', 'Live KDS Orders Terminal')

@section('content')
<div class="page-header mb-3 no-print">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="page-header-title">
                            <h2 class="mb-1 fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px; font-size: 1.6rem;">
                                <span class="live-indicator-dot me-2"></span>Live Orders Terminal
                            </h2>
                        </div>
                        <ul class="breadcrumb small text-muted bg-transparent p-0 m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none"><i class="ti ti-home me-1"></i>Home</a></li>
                            <li class="breadcrumb-item text-secondary">Order Management</li>
                            <li class="breadcrumb-item active text-danger fw-semibold">Real-time KDS</li>
                        </ul>
                    </div>
                    
                    {{-- Quick navigation help controls for kitchen staff --}}
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-light-danger text-danger border px-3 py-2 fw-bold" style="font-size: 11px; border-radius: 8px;">
                            <i class="ti ti-activity heartbeat me-1"></i> REALTIME POLLING ACTIVE
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🔥 OPTIMIZATION: Stripped padding out to allow absolute fluid fullscreen grid execution for kitchen screens --}}
<div class="container-fluid p-0 live-terminal-wrapper">
    @livewire('live-orders')
</div>

<style>
    /* Live status pulsing icon indicator rule setup */
    .live-indicator-dot {
        width: 12px;
        height: 12px;
        background-color: #ef4444;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        animation: pulse-red 2s infinite;
        vertical-align: middle;
    }

    .heartbeat {
        animation: heartbeat 1.5s infinite alternate;
    }

    @keyframes pulse-red {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    @keyframes heartbeat {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }

    /* KDS Terminal alignment constraints overrides */
    .live-terminal-wrapper {
        min-height: calc(100vh - 180px);
    }
    
    .bg-light-danger { background-color: #fee2e2 !important; border-color: #fca5a5 !important; }
</style>
@endsection