@extends('backend.layouts.app')

@section('title', 'Create Purchase Order')

@section('content')
<form action="#" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="card ">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Order Details</h5>
                    <div class="mb-3">
                        <label class="form-label">PO Number</label>
                        <input type="text" name="po_number" class="form-control fw-bold text-primary" value="{{ $po_number }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">-- Select Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }} ({{ $supplier->company_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order Date</label>
                        <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card ">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 d-flex justify-content-between">
                        Order Items
                        <button type="button" class="btn btn-sm btn-success" id="add-item-btn">+ Add Item</button>
                    </h5>
                    <table class="table align-middle" id="items-table">
                        <thead>
                            <tr>
                                <th width="40%">Item</th>
                                <th width="20%">Qty</th>
                                <th width="20%">Price</th>
                                <th width="20%">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="items[0][id]" class="form-select" required>
                                        <option value="">Select Item</option>
                                        @foreach($materials as $m)
                                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1"></td>
                                <td><input type="number" name="items[0][price]" class="form-control price" value="0" step="0.01"></td>
                                <td class="item-total">0.00</td>
                                <td><button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="ti ti-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-end mt-3">
                        <h4 class="fw-bold">Grand Total: Rs. <span id="grand-total">0.00</span></h4>
                        <button type="submit" class="btn btn-primary px-5 mt-2">Create Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    let rowCount = 1;
    $('#add-item-btn').click(function() {
        let newRow = `
            <tr>
                <td>
                    <select name="items[${rowCount}][id]" class="form-select" required>
                        <option value="">Select Item</option>
                        @foreach($materials as $m)
                            <option value="{{ $m->id }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="items[${rowCount}][qty]" class="form-control qty" value="1" min="1"></td>
                <td><input type="number" name="items[${rowCount}][price]" class="form-control price" value="0" step="0.01"></td>
                <td class="item-total">0.00</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="ti ti-trash"></i></button></td>
            </tr>`;
        $('#items-table tbody').append(newRow);
        rowCount++;
    });

    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        calculateTotal();
    });

    $(document).on('input', '.qty, .price', function() {
        let row = $(this).closest('tr');
        let qty = row.find('.qty').val() || 0;
        let price = row.find('.price').val() || 0;
        let total = qty * price;
        row.find('.item-total').text(total.toFixed(2));
        calculateTotal();
    });

    function calculateTotal() {
        let grandTotal = 0;
        $('.item-total').each(function() {
            grandTotal += parseFloat($(this).text());
        });
        $('#grand-total').text(grandTotal.toFixed(2));
    }
</script>
@endpush
@endsection