@extends('backend.layouts.app')

@section('content')
{{-- Order Notification Sound --}}
<audio id="order-beep" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

<div class="page-header" style="background: transparent; margin-bottom: 12px;">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="mb-0 fw-extrabold text-dark tracking-tight" style="font-size: 24px;">Kitchen Display System (KDS)</h4>
                    <p class="text-muted small mb-0 d-flex align-items-center" style="font-size: 12px;">
                        <span class="pulse-indicator me-2"></span> Live Monitoring Active
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3 bg-white px-3 py-2 rounded-3 shadow-sm border border-light-subtle">
                    <div class="text-end border-end pe-3">
                        <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 9px; letter-spacing: 0.5px;">Live Clock</span>
                        <h5 id="live-clock" class="mb-0 fw-bold font-monospace text-primary" style="font-size: 18px;">00:00:00</h5>
                    </div>
                    <div class="text-end">
                        <span class="text-muted text-uppercase fw-bold d-block" style="font-size: 9px; letter-spacing: 0.5px;">Queue Pool</span>
                        <span class="badge bg-danger rounded-pill px-2.5 py-1 fw-bold shadow-xs border-0" id="total-count" style="font-size: 12px;">
                            {{ count($orders) }} Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main KDS Grid Container --}}
<div class="row g-3" id="kds-container">
    @forelse($orders as $order)
    <div class="col-12 col-md-6 col-xl-4 order-card" id="order-{{ $order->id }}">
        <div class="card h-100 kds-premium-card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: #ffffff;">
            
            {{-- Modern Header Wrapper --}}
            <div class="p-3 d-flex justify-content-between align-items-center header-gradient-box {{ $order->status == 'pending' ? 'kds-header-pending' : 'kds-header-preparing' }}">
                <div>
                    <span class="text-uppercase fw-extrabold opacity-75 tracking-wider d-block mb-0.5" style="font-size: 9px;">TICKET TOKEN</span>
                    <h5 class="mb-0 fw-bold font-monospace text-dark" style="font-size: 16px;">#{{ substr($order->order_number, -6) }}</h5>
                </div>
                <div class="text-end">
                    <span class="text-uppercase fw-extrabold opacity-75 tracking-wider d-block mb-0.5" style="font-size: 9px;">ELAPSED</span>
                    <span class="timer badge bg-dark text-white rounded-2 py-1.5 px-2.5 fw-bold font-monospace" data-time="{{ $order->created_at }}" style="font-size: 12px;">00:00</span>
                </div>
            </div>

            {{-- Card Contents --}}
            <div class="card-body p-3 d-flex flex-column justify-content-between" style="min-height: 240px;">
                <div class="w-100">
                    {{-- Service Type & Tables Metatags --}}
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-light-subtle flex-wrap gap-2">
                        <div>
                            @if(str_replace('_', ' ', strtolower($order->order_type)) == 'dine in')
                                <span class="badge bg-light-primary text-primary px-2.5 py-1.5 rounded-2 fw-bold text-uppercase" style="font-size: 10px;">
                                    🍽️ Dine-In
                                </span>
                            @elseif(str_replace('_', ' ', strtolower($order->order_type)) == 'delivery')
                                <span class="badge bg-light-danger text-danger px-2.5 py-1.5 rounded-2 fw-bold text-uppercase" style="font-size: 10px;">
                                    🛵 Delivery
                                </span>
                            @else
                                <span class="badge bg-light-warning text-warning px-2.5 py-1.5 rounded-2 fw-bold text-uppercase" style="font-size: 10px;">
                                    🥡 Takeaway
                                </span>
                            @endif
                        </div>
                        <div>
                            <span class="fw-bold text-dark p-1.5 bg-light rounded-2 border text-uppercase tracking-tight" style="font-size: 11px; white-space: nowrap;">
                                <i class="ti ti-armchair text-muted me-1"></i> {{ $order->table->name ?? 'COUNTER' }}
                            </span>
                        </div>
                    </div>

                    {{-- Dynamic Scrollable Product Items List --}}
                    <div class="items-list custom-scrollbar pe-1" style="max-height: 180px; overflow-y: auto;">
                        @foreach($order->items as $item)
                        <div class="d-flex align-items-center mb-2 kds-item-row p-2 rounded-3 border border-light-subtle transition-base">
                            <div class="bg-primary text-white rounded-2 d-flex align-items-center justify-content-center fw-bold me-2 font-monospace flex-shrink-0" style="width: 28px; height: 28px; font-size: 12px;">
                                {{ $item->quantity }}x
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="mb-0 text-dark fw-bold text-truncate" style="font-size: 13.5px;">{{ $item->item_name }}</h6>
                                @if($item->notes) 
                                    <div class="bg-light-danger border border-danger-subtle px-2 py-1 rounded-2 mt-1">
                                        <small class="text-danger fw-semibold d-block text-truncate" style="font-size: 11px; font-style: italic;">
                                            <strong>Note:</strong> {{ $item->notes }}
                                        </small>
                                    </div> 
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bottom Action Buttons --}}
                <div class="mt-3">
                    @if($order->status == 'pending')
                        <button onclick="updateKDSStatus(this, {{ $order->id }}, 'preparing')" class="btn btn-warning w-100 fw-bold py-2.5 shadow-sm btn-kds-action text-uppercase tracking-wider border-0" style="background: linear-gradient(135deg, #ffb300, #ffa000); border-radius: 8px; font-size: 12px; color: #fff !important;">
                            <i class="ti ti-flame me-1 fs-5"></i> Start Cooking
                        </button>
                    @else
                        <button onclick="updateKDSStatus(this, {{ $order->id }}, 'ready')" class="btn w-100 fw-bold py-2.5 shadow-sm btn-kds-action text-uppercase tracking-wider border-0 text-white" style="background: linear-gradient(135deg, #00c853, #00b0ff); border-radius: 8px; font-size: 12px;">
                            <i class="ti ti-circle-check-filled me-1 fs-5"></i> Ready to Serve
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="py-5 bg-white rounded-3 shadow-sm border border-light-subtle">
            <i class="ti ti-tools-kitchen-2 text-muted opacity-25" style="font-size: 4rem;"></i>
            <h4 class="text-secondary mt-3 fw-extrabold">KITCHEN QUEUE IS CLEAR!</h4>
            <p class="text-muted small mb-0">New orders from POS terminal will appear here automatically.</p>
        </div>
    </div>
    @endforelse
</div>

<style>
    /* Premium Grid & Card Layout Styling */
    .transition-base { transition: all 0.2s ease-in-out; }
    
    .kds-premium-card {
        border: 1px solid #e2e8f0 !important;
        transition: all 0.2s ease-in-out;
    }
    
    .kds-premium-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.06) !important;
    }

    /* Dynamic Headers Status Styling */
    .header-gradient-box {
        border-bottom: 2px solid transparent;
    }
    .kds-header-pending {
        background: linear-gradient(135deg, #fffde7, #fff9c4) !important;
        border-bottom-color: #fbc02d !important;
    }
    .kds-header-preparing {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb) !important;
        border-bottom-color: #1e88e5 !important;
    }

    /* Row Styling Inside Card */
    .kds-item-row {
        background: #f8fafc;
    }
    .kds-item-row:hover {
        background: #f1f5f9;
        border-color: #cbd5e1 !important;
    }

    /* Micro-animations and Buttons Styling */
    .btn-kds-action {
        transition: all 0.2s ease;
    }
    .btn-kds-action:hover {
        filter: brightness(1.08);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12) !important;
    }

    /* Badge Overrides */
    .bg-light-primary { background-color: #e3f2fd !important; }
    .bg-light-danger { background-color: #ffebee !important; }
    .bg-light-warning { background-color: #fff8e1 !important; }

    /* Custom Webkit Smooth Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    /* Live Pulsing Dot Animation CSS */
    .pulse-indicator {
        width: 7px;
        height: 7px;
        background: #22c55e;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulseEffect 1.6s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes pulseEffect {
        to { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function updateKDSStatus(btn, orderId, newStatus) {
        const $btn = $(btn);
        const originalHtml = $btn.html();
        
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

        let url = "/admin/kds/update-status/" + orderId;

        $.ajax({
            url: url,
            type: 'POST',
            data: { 
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if(res.success) {
                    if(newStatus === 'ready') {
                        $(`#order-${orderId}`).fadeOut(400, function() { $(this).remove(); });
                    } else {
                        location.reload();
                    }
                } else {
                    alert("Failed: " + res.message);
                    $btn.prop('disabled', false).html(originalHtml);
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalHtml);
                if(xhr.status === 419) {
                    alert("Session Expired! Please refresh the page.");
                } else {
                    alert("Error: " + (xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong"));
                }
            }
        });
    }

    function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').innerText = now.toLocaleTimeString('en-GB');
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection