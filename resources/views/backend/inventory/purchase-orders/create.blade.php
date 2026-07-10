@extends('backend.layouts.app')
@section('content')
<div class="container-fluid py-4">
    <form action="{{ route('admin.inventory.purchase-orders.store') }}" method="POST" id="purchaseOrderForm">
        @csrf
        <input type="hidden" name="total_amount" id="total_amount_input" value="0">
        
        <div class="row g-4 d-flex align-items-stretch">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4 text-dark">Order Details</h5>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">PO NUMBER</label>
                            <input type="text" name="po_number" class="form-control bg-light fw-bold" value="{{ $po_number }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">SUPPLIER *</label>
                            <select name="supplier_id" class="form-select border-1" required>
                                <option value="">-- Select Supplier --</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">ORDER DATE</label>
                            <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted small fw-bold">NOTES</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0 text-dark">Order Items</h5>
                            <button type="button" id="add-item-btn" class="btn btn-success btn-sm px-3 shadow-sm">+ Add Item</button>
                        </div>
                        
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover align-middle" id="items-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="40%" class="text-muted small fw-bold">ITEM</th>
                                        <th width="20%" class="text-muted small fw-bold">QTY</th>
                                        <th width="20%" class="text-muted small fw-bold">PRICE</th>
                                        <th width="15%" class="text-muted small fw-bold text-end">TOTAL</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="item-row">
                                        <td>
                                            <select name="items[0][id]" class="form-select" required>
                                                <option value="">Select Item</option>
                                                @foreach($materials as $m)
                                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][qty]" class="form-control qty-input text-center" value="1" min="1" step="1">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][price]" class="form-control price-input text-end" value="0" min="0" step="1">
                                        </td>
                                        <td class="text-end fw-bold">
                                            <span class="row-total">0.00</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-row">×</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top pt-3 mt-4 text-end">
                            <h4 class="text-muted mb-1 small fw-bold text-uppercase">Grand Total</h4>
                            <h2 class="fw-bold text-primary mb-3">Rs. <span id="grand-total-display">0.00</span></h2>
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow w-100">Save Purchase Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let rowIdx = 1;

    // Add Row logic
    $('#add-item-btn').on('click', function() {
        let rowHtml = `
            <tr class="item-row">
                <td>
                    <select name="items[${rowIdx}][id]" class="form-select" required>
                        <option value="">Select Item</option>
                        @foreach($materials as $m) <option value="{{ $m->id }}">{{ $m->name }}</option> @endforeach
                    </select>
                </td>
                <td><input type="number" name="items[${rowIdx}][qty]" class="form-control qty-input text-center" value="1" min="1" step="1"></td>
                <td><input type="number" name="items[${rowIdx}][price]" class="form-control price-input text-end" value="0" min="0" step="1"></td>
                <td class="text-end fw-bold"><span class="row-total">0.00</span></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-row">×</button>
                </td>
            </tr>`;
        $('#items-table tbody').append(rowHtml);
        rowIdx++;
    });

    // Remove Row
    $(document).on('click', '.remove-row', function() {
        if ($('#items-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateGrandTotal();
        }
    });

    // Calculation Logic
    $(document).on('input change', '.qty-input, .price-input', function() {
        let row = $(this).closest('tr');
        
        // Negative preventer
        let q = parseInt(row.find('.qty-input').val());
        if (isNaN(q) || q < 1) { q = 1; row.find('.qty-input').val(1); }
        
        let p = parseFloat(row.find('.price-input').val());
        if (isNaN(p) || p < 0) { p = 0; row.find('.price-input').val(0); }

        let total = q * p;
        row.find('.row-total').text(total.toLocaleString(undefined, {minimumFractionDigits: 2}));
        calculateGrandTotal();
    });

    function calculateGrandTotal() {
        let gt = 0;
        $('.row-total').each(function() {
            let val = $(this).text().replace(/,/g, '');
            gt += parseFloat(val) || 0;
        });
        $('#grand-total-display').text(gt.toLocaleString(undefined, {minimumFractionDigits: 2}));
        $('#total_amount_input').val(gt.toFixed(2));
    }
});
</script>
@endpush
@endsection