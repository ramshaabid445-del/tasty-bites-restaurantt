@extends('backend.layouts.app')

{{-- 🔥 ADDED: Dynamic Browser Tab Title Wrapper --}}
@section('title', 'Order Details - #' . $order->order_number)

@section('content')
<div class="page-header mb-4 no-print">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h2 class="mb-1 fw-bold text-dark">Order Invoice Detailed Summary</h2>
                        <p class="text-muted small mb-0">System Ref Tracker: <span class="fw-bold text-primary">#{{ $order->order_number }}</span></p>
                    </div>
                    <a href="{{ route('admin.orders.history') }}" class="btn btn-sm btn-secondary shadow-sm px-3 border-0 d-inline-flex align-items-center" style="background-color: #4b5563; border-radius: 8px;">
                        <i class="ti ti-arrow-back me-1.5 fs-5"></i> Back to History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Invoice Content Area Grid --}}
<div class="row g-4 align-items-stretch print-invoice-container"> 
    {{-- Left Side: Order Items Details Panel --}}
    <div class="col-lg-8 main-bill-panel">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 12px; overflow: hidden; background: #fff;">
            <div class="card-header bg-white py-3 border-bottom border-light d-flex align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list-details me-2 text-primary fs-4"></i>Items Summary</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-uppercase small text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                                <th class="ps-4 py-3" style="font-weight: 700;">Item Description</th>
                                <th class="text-center py-3" style="font-weight: 700; width: 140px;">Unit Price</th>
                                <th class="text-center py-3" style="font-weight: 700; width: 90px;">Qty</th>
                                <th class="text-end pe-4 py-3" style="font-weight: 700; width: 140px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center me-3 no-print" style="width: 35px; height: 35px;">
                                            <i class="ti ti-tools-kitchen-2 text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-semibold text-dark d-block" style="font-size: 0.95rem;">{{ $item->item_name }}</span>
                                            @if(isset($item->notes) && $item->notes) 
                                                <small class="text-danger fw-medium d-block mt-0.5" style="font-style: italic;">⚠️ Note: {{ $item->notes }}</small> 
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-medium text-secondary">Rs {{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light-primary text-primary px-2.5 py-1.5 fw-bold" style="font-size: 12px; border-radius: 6px;">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-end pe-4 fw-bold text-dark">Rs {{ number_format($item->sub_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Bottom Total Calculations Card Footer --}}
            <div class="card-footer bg-white py-4 border-top border-light">
                <div class="row justify-content-end">
                    <div class="col-md-6 col-sm-8">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">Sub Total Amount:</span>
                            <span class="fw-semibold text-dark">Rs {{ number_format($order->sub_total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">Tax Collected (GST):</span>
                            <span class="fw-semibold text-dark">Rs {{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        <div class="border-top my-2 border-light"></div>
                        <div class="d-flex justify-content-between align-items-center pt-1">
                            <h5 class="fw-bold text-primary mb-0" style="font-size: 1.15rem;">Grand Total:</h5>
                            <h4 class="fw-bold text-primary mb-0" style="font-size: 1.3rem;">Rs {{ number_format($order->total_amount, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side: Meta Context & Tracking Sidecards Panels --}}
    <div class="col-lg-4 d-flex flex-column side-meta-panel">
        {{-- Order Workflow Status Tracker Metrics Card --}}
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-activity me-2 text-secondary"></i>Order Tracking</h5>
            </div>
            <div class="card-body">
                <div class="mb-4 text-center">
                    {{-- 🔥 FIX 1: Comprehensive Dynamic Status Badge Styling Array Context Mapping --}}
                    @if($order->status == 'pending')
                        <span class="badge bg-light-warning text-warning border-0 px-4 py-2 w-100 text-uppercase" style="letter-spacing: 0.5px; font-size: 12px; border-radius: 8px;">🕒 PENDING</span>
                    @elseif($order->status == 'processing')
                        <span class="badge bg-light-primary text-primary border-0 px-4 py-2 w-100 text-uppercase" style="letter-spacing: 0.5px; font-size: 12px; border-radius: 8px;">🍳 COOKING IN KITCHEN</span>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-light-success text-success border-0 px-4 py-2 w-100 text-uppercase" style="letter-spacing: 0.5px; font-size: 12px; border-radius: 8px;">✅ COMPLETED & SERVED</span>
                    @else
                        <span class="badge bg-light-danger text-danger border-0 px-4 py-2 w-100 text-uppercase" style="letter-spacing: 0.5px; font-size: 12px; border-radius: 8px;">❌ CANCELLED TRANSACTION</span>
                    @endif
                </div>
                
                <div class="d-flex justify-content-between mb-3 border-bottom border-light pb-2">
                    <span class="text-muted"><i class="ti ti-category me-2"></i>Service Type:</span>
                    <span class="fw-bold text-dark text-uppercase small" style="letter-spacing: 0.3px;">{{ str_replace('_', ' ', $order->order_type) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom border-light pb-2">
                    <span class="text-muted"><i class="ti ti-credit-card me-2"></i>Payment Mode:</span>
                    <span class="fw-bold text-dark text-uppercase small" style="letter-spacing: 0.3px;">{{ $order->payment_method ?? 'CASH' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted"><i class="ti ti-armchair me-2"></i>Dining Destination:</span>
                    <span class="text-primary fw-bold badge bg-light-primary px-2.5 py-1.5" style="font-size: 12px;">{{ $order->table->name ?? 'Take Away Counter' }}</span>
                </div>
            </div>
        </div>

        {{-- Registered Customer Details Metrics Card --}}
        <div class="card shadow-sm border-0 mb-auto" style="border-radius: 12px; background: #fff;">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-user me-2 text-secondary"></i>Customer Info</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light-secondary rounded-circle d-flex align-items-center justify-content-center me-3 no-print" style="width: 45px; height: 45px;">
                        <i class="ti ti-user text-secondary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">{{ $order->customer_name ?? 'Walk-in Guest' }}</h6>
                        <small class="text-muted d-block mt-0.5"><i class="ti ti-phone me-1 small"></i>{{ $order->customer_phone ?? 'No Phone Logged' }}</small>
                    </div>
                </div>
                
                {{-- Print Executor Button Group Wrapper --}}
                <button onclick="window.print()" class="btn btn-primary w-100 py-2.5 shadow-none border-0 d-flex align-items-center justify-content-center no-print" style="background-color: #7267ef; border-radius: 8px; font-weight: 600;">
                    <i class="ti ti-printer me-2 fs-5"></i> Trigger Thermal Print
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 🔥 FIX 2: Specialized Embedded Production Core Print Layout Media Rules Overrides Styles --}}
<style>
    .bg-light-primary { background-color: #e0e7ff !important; }
    .bg-light-secondary { background-color: #f3f4f6 !important; }
    .bg-light-success { background-color: #d1fae5 !important; }
    .bg-light-warning { background-color: #fef3c7 !important; }
    .bg-light-danger { background-color: #fee2e2 !important; }
    .col-lg-8, .col-lg-4 { margin-top: 0 !important; }

    @media print {
        /* Hide layout sections inside admin shells metrics structures */
        .no-print, 
        .pc-sidebar, 
        .pc-header, 
        .pc-footer, 
        .breadcrumb,
        .card-header i,
        button { 
            display: none !important; 
        }
        
        /* Reset structural bodies padding spacing boundaries */
        body, .pc-container, .pc-content {
            background-color: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Enforce columns blocks full width scaling adjustments rules */
        .main-bill-panel {
            width: 100% !important;
            display: block !important;
        }

        .side-meta-panel {
            display: block !important;
            width: 100% !important;
            margin-top: 20px !important;
            page-break-inside: avoid;
        }

        .card {
            border: 1px solid #e3e8ef !important;
            box-shadow: none !important;
            border-radius: 0px !important;
        }
        
        .table {
            width: 100% !important;
        }
    }
</style>
@endsection