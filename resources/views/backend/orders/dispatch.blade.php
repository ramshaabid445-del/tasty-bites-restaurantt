@extends('backend.layouts.app')

@section('content')
<div class="page-header mb-3" style="background: transparent;">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h4 class="mb-1 fw-extrabold text-dark tracking-tight" style="font-size: 22px;">Order Dispatch / Handover</h4>
                </div>
                <ul class="breadcrumb small text-muted bg-transparent p-0 m-0" style="font-size: 11.5px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted"><i class="ti ti-home me-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item text-secondary">Sales Management</li>
                    <li class="breadcrumb-item active text-primary fw-semibold">Dispatch Queue</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px; background: #ffffff;">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-dark" style="font-size: 15px;">Orders Ready for Dispatch</h5>
                <small class="text-muted d-block mt-0.5" style="font-size: 11.5px;">Manage operational worker handovers and logistics routing</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive custom-table-scroll">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-uppercase small text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                                <th class="ps-4 py-3" style="font-weight: 700;">Order ID</th>
                                <th style="font-weight: 700;">Customer / Table</th>
                                <th style="font-weight: 700;">Order Type</th>
                                <th style="font-weight: 700;">Status</th>
                                <th class="pe-4" style="font-weight: 700; min-width: 300px; width: 320px;">Assign To & Action</th>
                            </tr>
                        </thead>
                        <tbody id="dispatch-orders-tbody">
                            @forelse($orders as $order)
                                <tr id="order-row-{{ $order->id }}">
                                    <td class="ps-4">
                                        <span class="fw-bold text-primary font-monospace" style="font-size: 13.5px;">#{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark mb-0.5" style="font-size: 13px; white-space: nowrap;">
                                                @if(isset($order->table) && $order->table)
                                                    <i class="ti ti-armchair text-muted me-1.5"></i>{{ $order->table->name }}
                                                @elseif(isset($order->table_name) && $order->table_name)
                                                    <i class="ti ti-armchair text-muted me-1.5"></i>{{ $order->table_name }}
                                                @else
                                                    <i class="ti ti-shopping-bag text-muted me-1.5"></i>Counter Order
                                                @endif
                                            </span>
                                            @if($order->customer_name)
                                                <small class="text-muted text-truncate" style="font-size: 11px; max-width: 180px;">{{ $order->customer_name }}</small>
                                            @else
                                                <small class="text-muted" style="font-size: 11px;">Walk-in Guest</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge px-2.5 py-1.5 text-uppercase fw-extrabold" style="font-size: 9.5px; border-radius: 6px; white-space: nowrap; background-color: #e3f2fd !important; color: #1e88e5 !important;">
                                            {{ str_replace('_', '-', strtoupper($order->order_type ?? 'N/A')) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-success text-success border-0 px-2.5 py-1.5 fw-extrabold text-uppercase" style="font-size: 9.5px; border-radius: 6px; white-space: nowrap;">
                                            <i class="ti ti-circle-check me-1"></i>{{ $order->status }}
                                        </span>
                                    </td>
                                    
                                    <td class="pe-4">
                                        {{-- 🔥 FIXED: Corrected dynamic form handler parameter structure --}}
                                        <form class="m-0 dispatch-ajax-form" data-order-id="{{ $order->id }}">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            
                                            <div class="input-group" style="border-radius: 8px; overflow: hidden; border: 1px solid #cbd5e1; background: #ffffff;">
                                                <select name="assigned_staff_id" class="form-select border-0 bg-transparent shadow-none ps-3" required style="cursor: pointer; font-size: 12.5px; height: 36px;">
                                                    <option value="">Select Staff</option>
                                                    @foreach($staff as $person)
                                                        <option value="{{ $person->id }}">
                                                            {{ $person->name }} ({{ $person->designation ?? 'Staff' }})
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <button type="submit" class="btn btn-primary fw-bold px-3 border-0 d-inline-flex align-items-center text-uppercase tracking-wider transition-base" style="font-size: 11px; height: 36px;">
                                                    <i class="ti ti-send me-1"></i>
                                                    <span>Dispatch</span>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-dispatch-row">
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted py-4 opacity-75">
                                            <i class="ti ti-package-off mb-2 text-secondary opacity-50" style="font-size: 3.5rem; display: block;"></i>
                                            <h5 class="fw-extrabold text-secondary">No Orders Ready to Dispatch</h5>
                                            <p class="small text-muted mb-0">Orders will auto-populate as soon as the Kitchen terminal flags them.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-base { transition: all 0.2s ease-in-out; }
    .table th { background-color: #f8fafc !important; border-bottom: 1px solid #e2e8f0 !important; }
    .table td { padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
    .input-group:focus-within { border-color: #5d87ff !important; box-shadow: 0 0 0 3px rgba(93, 135, 255, 0.15) !important; }
    .form-select:hover { background-color: #f8fafc; }
    .custom-table-scroll::-webkit-scrollbar { height: 5px; }
    .custom-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .bg-light-success { background-color: #d1fae5 !important; color: #065f46 !important; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // 🔥 FIXED: Single clean event listener framework to stop double triggering loops
        $(document).on('submit', '.dispatch-ajax-form', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var form = $(this);
            var orderId = form.data('order-id');
            var btn = form.find('button[type="submit"]');
            var selectVal = form.find('select[name="assigned_staff_id"]').val();
            var tokenVal = form.find('input[name="_token"]').val();
            
            if(!selectVal) {
                alert('Please select a staff member first.');
                return false;
            }

            // Loader State Switch
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            // Secure Dynamic Safe Base URL mapping construction
            var baseRoute = "{{ route('admin.orders.updateStatus', ':id') }}";
            var postUrl = baseRoute.replace(':id', orderId);

            $.ajax({
                url: postUrl,
                type: "POST",
                data: {
                    _token: tokenVal,
                    _method: "PUT", // Laravel explicit routing protection override standard
                    status: 'completed',
                    assigned_staff_id: selectVal
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || tokenVal
                },
                success: function(response) {
                    // Check standard json key responses
                    if(response && (response.success === true || response.success === "true" || response.status === "success")) {
                        // Smooth Row wipe out effect 
                        $('#order-row-' + orderId).fadeOut(400, function() {
                            $(this).remove();
                            
                            // Check if table is empty now
                            if ($('#dispatch-orders-tbody tr[id^="order-row-"]').length === 0) {
                                $('#dispatch-orders-tbody').html(`
                                    <tr id="empty-dispatch-row">
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted py-4 opacity-75">
                                                <i class="ti ti-package-off mb-2 text-secondary opacity-50" style="font-size: 3.5rem; display: block;"></i>
                                                <h5 class="fw-extrabold text-secondary">No Orders Ready to Dispatch</h5>
                                                <p class="small text-muted mb-0">Orders will auto-populate as soon as the Kitchen terminal flags them.</p>
                                            </div>
                                        </td>
                                    </tr>
                                `);
                            }
                        });
                    } else {
                        var backendMsg = (response && response.message) ? response.message : 'The request could not be completed.';
                        alert('Application Logic Error:\n' + backendMsg);
                        resetButtonState(btn);
                    }
                },
                error: function(xhr) {
                    var errLog = getAjaxErrorMessage(xhr);
                    alert('Server Error Encountered:\n' + errLog);
                    resetButtonState(btn);
                }
            });

            return false;
        });
    });

    function getAjaxErrorMessage(xhr) {
        if (xhr.responseJSON && xhr.responseJSON.message) {
            return xhr.responseJSON.message;
        }
        if (xhr.responseText) {
            try {
                var parsed = JSON.parse(xhr.responseText);
                if (parsed && parsed.message) {
                    return parsed.message;
                }
            } catch(e) {
                if (xhr.responseText.trim().charAt(0) === '<') {
                    return 'Server returned an HTML error page (HTTP ' + xhr.status + ').';
                }
            }
        }
        return 'Unknown execution error logic.';
    }

    function resetButtonState(btn) {
        btn.prop('disabled', false).html('<i class="ti ti-send me-1"></i> <span>Dispatch</span>');
    }
</script>
@endsection