@extends('backend.layouts.master')

@section('content')
<audio id="order-beep" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold text-dark">Kitchen Display System (KDS)</h4>
                            <p class="text-muted small mb-0"><i class="ti ti-circle-filled text-success me-1"></i> System Live & Monitoring</p>
                        </div>
                        <div class="text-end">
                            <h3 id="live-clock" class="mb-0 fw-bold text-primary">00:00:00</h3>
                            <span class="badge bg-light-danger text-danger border border-danger shadow-sm" id="total-count" style="font-size: 0.9rem;">
                                {{ count($orders) }} Active Orders
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2" id="kds-container">
            @forelse($orders as $order)
            <div class="col-sm-6 col-xl-3 order-card" id="order-{{ $order->id }}">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="p-3 d-flex justify-content-between align-items-center {{ $order->status == 'pending' ? 'bg-light-warning' : 'bg-light-primary' }}">
                        <div>
                            <span class="text-muted small d-block uppercase fw-bold">Order ID</span>
                            <h5 class="mb-0 fw-bold text-dark">#{{ substr($order->order_number, -5) }}</h5>
                        </div>
                        <div class="text-end">
                            <span class="timer badge bg-white text-dark shadow-sm py-2 px-3 fw-bold fs-6" data-time="{{ $order->created_at }}">00:00</span>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light-secondary text-secondary fw-bold text-uppercase">{{ $order->order_type }}</span>
                            <span class="text-primary fw-bold"><i class="ti ti-armchair me-1"></i>{{ $order->table->name ?? 'TAKEAWAY' }}</span>
                        </div>

                        <div class="items-list custom-scrollbar" style="max-height: 250px; overflow-y: auto;">
                            @foreach($order->items as $item)
                            <div class="d-flex align-items-start mb-3 border-bottom border-light pb-2">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3 shadow-sm" style="min-width: 32px; height: 32px; font-size: 14px;">
                                    {{ $item->quantity }}x
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-dark fw-semibold">{{ $item->item_name }}</h6>
                                    @if($item->notes) <small class="text-danger italic">Note: {{ $item->notes }}</small> @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 p-3">
                        @if($order->status == 'pending')
                            <button onclick="updateKDSStatus({{ $order->id }}, 'processing')" class="btn btn-warning w-100 fw-bold py-2 shadow-sm">
                                <i class="ti ti-flame me-1"></i> START COOKING
                            </button>
                        @else
                            <button onclick="updateKDSStatus({{ $order->id }}, 'completed')" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                <i class="ti ti-check me-1"></i> READY TO SERVE
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="py-5">
                    <i class="ti ti-tools-kitchen-2 text-muted opacity-25" style="font-size: 6rem;"></i>
                    <h2 class="text-muted mt-3 fw-bold">ALL CLEAR!</h2>
                    <p class="text-muted">No pending orders in the kitchen.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Mantis Theme Colors & Overrides */
    .bg-light-warning { background-color: #fff8e1; border-bottom: 2px solid #ffc107; }
    .bg-light-primary { background-color: #e3f2fd; border-bottom: 2px solid #2196f3; }
    .timer-danger { background-color: #ff5252 !important; color: #fff !important; animation: blink-red 1s infinite; }
    
    @keyframes blink-red { 50% { opacity: 0.7; } }
    
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
    
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-5px); }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // 1. Live Clock & Timer Logic
    function updateTimers() {
        const now = new Date();
        document.getElementById('live-clock').innerText = now.toLocaleTimeString();

        $('.timer').each(function() {
            const startTime = new Date($(this).data('time'));
            const diff = Math.floor((now - startTime) / 1000);
            const mins = Math.floor(diff / 60);
            const secs = diff % 60;
            $(this).text(`${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`);
            
            if (mins >= 15) $(this).addClass('timer-danger');
        });
    }
    setInterval(updateTimers, 1000);

    // 2. AJAX Status Update
    function updateKDSStatus(orderId, status) {
        $.post(`{{ url('/admin/kds/update-status') }}/${orderId}`, {
            _token: '{{ csrf_token() }}',
            status: status
        }, function(res) {
            if(status === 'completed') {
                $(`#order-${orderId}`).fadeOut(300, function() { $(this).remove(); });
            } else {
                location.reload(); 
            }
        });
    }

    // 3. Auto Refresh every 30 seconds for new orders
    let lastOrderCount = {{ count($orders) }};
    setInterval(function() {
        $.get('{{ route("admin.kds.index") }}', function(data) {
            const newOrdersHTML = $(data).find('#kds-container').html();
            const newCount = $(data).find('.order-card').length;
            
            if (newCount > lastOrderCount) {
                document.getElementById('order-beep').play();
            }
            
            if (newCount !== lastOrderCount) {
                $('#kds-container').html(newOrdersHTML);
                $('#total-count').text(newCount + ' Active Orders');
                lastOrderCount = newCount;
            }
        });
    }, 30000);
</script>
@endsection