<?php

use Livewire\Component;
use App\Models\Order;

new class extends Component {
    public function markAsReady($orderId) {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'ready']);
            $this->dispatch('notify', ['message' => 'Order #'.$order->order_number.' marked as ready!']);
        }
    }

    public function render() {
        return view('livewire.live-orders', [
            'orders' => Order::with(['items.menuItem', 'table'])
                ->whereIn('status', ['pending', 'preparing', 'delayed'])
                ->latest()
                ->get()
        ]);
    }
}; ?>

<div wire:poll.8s>
    <div class="row g-4">
        @forelse($orders as $order)
            <div class="col-md-6 col-xl-4" wire:key="order-{{ $order->id }}">
                <div class="card order-terminal-card border-0 shadow-sm h-100">
                    <div class="status-top-bar {{ $order->status == 'delayed' ? 'bg-danger' : ($order->status == 'preparing' ? 'bg-primary' : 'bg-warning') }}"></div>
                    
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 fw-bold text-dark">#{{ $order->order_number }}</h4>
                                <small class="text-muted"><i class="feather icon-clock me-1"></i>{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge {{ $order->status == 'delayed' ? 'badge-light-danger' : ($order->status == 'preparing' ? 'badge-light-primary' : 'badge-light-warning') }} text-uppercase">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-0 bg-light rounded-3 p-3 mb-4">
                            <div class="col-6 border-end text-center">
                                <label class="d-block text-muted small-label">TYPE</label>
                                <span class="fw-bold">{{ str_replace('_', ' ', ucfirst($order->order_type)) }}</span>
                            </div>
                            <div class="col-6 text-center">
                                <label class="d-block text-muted small-label">LOCATION</label>
                                <span class="badge bg-dark rounded-pill">{{ $order->table->name ?? 'Take Away' }}</span>
                            </div>
                        </div>

                        <div class="order-items-wrapper">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3">Order Details</h6>
                            <div class="custom-scroll" style="max-height: 180px; overflow-y: auto;">
                                @foreach($order->items as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded-2 bg-white border-light border">
                                        <div class="d-flex align-items-center">
                                            <span class="qty-tag me-2">{{ $item->quantity }}</span>
                                            <span class="fw-semibold text-dark small">{{ $item->menuItem->name ?? 'Menu Item' }}</span>
                                        </div>
                                        <span class="text-muted small">Rs. {{ number_format($item->price * $item->quantity) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pt-0 pb-4">
                        <hr class="border-dashed mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                            <span class="text-muted fw-bold">Total Payable</span>
                            <h4 class="mb-0 fw-bolder text-success">Rs. {{ number_format($order->total_amount) }}</h4>
                        </div>
                        
                        <button wire:click="markAsReady({{ $order->id }})" 
                                wire:loading.attr="disabled"
                                class="btn btn-primary w-100 py-2 fw-bold shadow-sm ready-btn">
                            <span wire:loading.remove wire:target="markAsReady">
                                MARK AS READY
                            </span>
                            <span wire:loading wire:target="markAsReady">
                                <span class="spinner-border spinner-border-sm"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm p-5">
                    <h4 class="text-muted">No Live Orders Right Now</h4>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* Mantis Theme Compatible Styles */
    .order-terminal-card {
        border-radius: 12px !important;
        transition: 0.3s ease-in-out;
    }
    .order-terminal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .status-top-bar {
        height: 5px;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
    .small-label { font-size: 9px; font-weight: 800; letter-spacing: 0.5px; }
    .qty-tag {
        background: #f0f2f5;
        color: #5b6b79;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    .border-dashed { border-top: 1px dashed #e6ebf1; }
    .ready-btn {
        background: #4680ff; /* Mantis Primary Blue */
        border: none;
        border-radius: 8px;
    }
    .badge-light-primary { background: #e9f0ff; color: #4680ff; }
    .badge-light-warning { background: #fff8e1; color: #ffab00; }
    .badge-light-danger { background: #fff0f0; color: #ff4d4f; }
    
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #e6ebf1; border-radius: 10px; }
</style>