@extends('backend.layouts.app')

@section('title', 'POS - Billing Counter')

@section('content')
<div style="background-color: #f4f7fa; min-height: 100vh; padding: 15px;">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3 d-flex align-items-center">
            <i class="ti ti-circle-check me-2 fs-4"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-3">
        {{-- Left Side: Menu Items Selection Grid --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 12px; height: calc(100vh - 100px); display: flex; flex-direction: column;">
                
                <div class="card-header bg-white border-0 pt-3 pb-2">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h4 class="mb-0 fw-bold text-dark">Menu Selection</h4>
                        <div class="input-group w-sm-50 w-100 shadow-sm border rounded-pill overflow-hidden">
                            <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                            <input type="text" id="itemSearch" class="form-control border-0 ps-0 shadow-none" placeholder="Search dish..." onkeyup="filterItems()">
                        </div>
                    </div>

                    <div class="d-flex gap-2 overflow-auto pb-2 custom-scrollbar" id="category-filters" style="white-space: nowrap;">
                        <button class="btn btn-primary rounded-pill btn-sm px-4 filter-btn" onclick="filterByCategory('all', this)">All Items</button>
                        @foreach($categories as $cat)
                            <button class="btn btn-outline-secondary rounded-pill btn-sm px-4 filter-btn" onclick="filterByCategory('{{ $cat->id }}', this)">{{ $cat->name }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="card-body p-3" style="overflow-y: auto; flex-grow: 1;">
                    <div id="itemsGrid" class="d-flex flex-column gap-2">
                        @forelse($menuItems as $item)
                        <div class="menu-item-row" data-category="{{ $item->category_id }}" onclick="addToCart({{ $item->id }}, {{ json_encode($item->name) }}, {{ $item->price }})">
                            <div class="d-flex align-items-center p-2 bg-white border rounded-3 shadow-sm item-hover-effect">
                                <div class="flex-shrink-0">
                                    @php $imgPath = 'uploads/menu_items/'.$item->image; @endphp
                                    @if($item->image && file_exists(public_path($imgPath)))
                                        <img src="{{ asset($imgPath) }}" class="rounded-2" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="ti ti-tools-kitchen-2 text-muted fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0 fw-bold text-dark" style="font-size: 14px;">{{ $item->name }}</h6>
                                    <small class="text-muted" style="font-size: 11px;">{{ $item->category->name ?? 'General' }}</small>
                                </div>
                                <div class="text-end me-2">
                                    <span class="fw-bold text-primary">Rs {{ number_format($item->price, 0) }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted">
                            <i class="ti ti-clipboard-off opacity-50" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">No items found in system.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Current Order Summary Box --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0" style="border-radius: 12px; height: calc(100vh - 100px); display: flex; flex-direction: column;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Current Order</h5>
                    <button class="btn btn-sm btn-outline-danger border-0 rounded-pill px-3" onclick="clearCart()">Clear All</button>
                </div>

                <div class="flex-grow-1" style="overflow-y: auto;">
                    <table class="table align-middle mb-0">
                        <tbody id="cart-items">
                            {{-- Target Body injected dynamically via JavaScript --}}
                        </tbody>
                    </table>
                </div>

                <div class="p-3 bg-light border-top mt-auto">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Sub Total</span>
                        <span class="fw-bold small text-dark" id="cart-subtotal">Rs 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted small">Tax (5%)</span>
                        <span class="fw-bold text-danger small" id="cart-tax">Rs 0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Total Amount</h5>
                        <h4 class="mb-0 fw-bold text-primary" id="cart-total">Rs 0</h4>
                    </div>

                    <form action="{{ route('admin.pos.store') }}" method="POST" id="pos-form">
                        @csrf
                        <input type="hidden" name="cart_data" id="cart_data">

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <select name="order_type" id="order_type" class="form-select border-2 rounded-3 shadow-none fw-semibold" onchange="toggleTableSelection()">
                                    <option value="dine_in">🍽️ Dine-In</option>
                                    <option value="takeaway">🥡 Takeaway</option>
                                    <option value="delivery">🛵 Delivery</option>
                                </select>
                            </div>
                            <div class="col-6" id="table-selection-div">
                                <select name="table_id" id="table_id" class="form-select border-2 rounded-3 shadow-none fw-semibold">
                                    <option value="">Table #</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-3">
                            <input type="radio" class="btn-check" name="payment_method" id="pay_cash" value="cash" checked>
                            <label class="btn btn-outline-success w-100 fw-bold py-2 rounded-3 shadow-xs" for="pay_cash">
                                <i class="ti ti-cash me-1"></i> CASH
                            </label>

                            <input type="radio" class="btn-check" name="payment_method" id="pay_card" value="card">
                            <label class="btn btn-outline-primary w-100 fw-bold py-2 rounded-3 shadow-xs" for="pay_card">
                                <i class="ti ti-credit-card me-1"></i> CARD
                            </label>
                        </div>

                        <button type="button" onclick="finalizeOrder()" id="submitBtn" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm text-uppercase" style="background-color: #7267ef; border: none;">
                            <span id="btnText">Place Order</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .menu-item-row { cursor: pointer; transition: 0.2s; }
    .item-hover-effect { transition: all 0.2s ease-in-out; border: 1px solid #e3e8ef !important; }
    .item-hover-effect:hover { border-color: #7267ef !important; background-color: #f8f7ff !important; transform: translateX(4px); }
    
    /* Checked State Styles Fixes */
    .btn-check:checked + .btn-outline-success { background-color: #2e7d32 !important; color: #fff !important; border-color: #2e7d32 !important; }
    .btn-check:checked + .btn-outline-primary { background-color: #7267ef !important; color: #fff !important; border-color: #7267ef !important; }
    
    /* Scrollbar UI Fixes */
    .custom-scrollbar::-webkit-scrollbar { height: 5px; width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }

    @media (max-width: 991px) { 
        .card { height: auto !important; margin-bottom: 15px; } 
    }
</style>

<script>
    let cart = [];

    function addToCart(id, name, price) {
        let item = cart.find(i => i.id === id);
        if(item) { 
            item.quantity++; 
        } else { 
            cart.push({ id: id, name: name, price: parseFloat(price), quantity: 1 }); 
        }
        renderCart();
    }

    function renderCart() {
        let cartBody = document.getElementById('cart-items');
        let subTotal = 0;
        cartBody.innerHTML = '';

        if(cart.length === 0) {
            cartBody.innerHTML = '<tr><td class="text-center py-5 text-muted small"><i class="ti ti-shopping-cart-x fs-3 d-block mb-1 opacity-50"></i>Cart is empty</td></tr>';
        } else {
            cart.forEach((item, index) => {
                let total = item.price * item.quantity;
                subTotal += total;
                cartBody.innerHTML += `
                    <tr class="border-bottom">
                        <td class="ps-3 py-2" style="width: 50%;">
                            <div class="fw-bold small text-dark text-truncate" style="max-width: 160px;">${item.name}</div>
                            <small class="text-muted">Rs ${item.price.toLocaleString()}</small>
                        </td>
                        <td class="py-2">
                            <div class="d-flex align-items-center border rounded-pill px-1 bg-white" style="width: fit-content;">
                                <button type="button" class="btn btn-sm p-0 px-2 fw-bold shadow-none border-0" onclick="updateQty(${index}, -1)">-</button>
                                <span class="mx-1 fw-bold small text-dark" style="min-width: 15px; text-align: center;">${item.quantity}</span>
                                <button type="button" class="btn btn-sm p-0 px-2 fw-bold shadow-none border-0" onclick="updateQty(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td class="text-end pe-3 fw-bold small text-dark">Rs ${total.toLocaleString()}</td>
                    </tr>`;
            });
        }

        let tax = subTotal * 0.05;
        let grandTotal = subTotal + tax;
        
        document.getElementById('cart-subtotal').innerText = 'Rs ' + Math.round(subTotal).toLocaleString();
        document.getElementById('cart-tax').innerText = 'Rs ' + Math.round(tax).toLocaleString();
        document.getElementById('cart-total').innerText = 'Rs ' + Math.round(grandTotal).toLocaleString();
    }

    function updateQty(index, change) {
        cart[index].quantity += change;
        if(cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        renderCart();
    }

    function clearCart() { 
        if(confirm('Are you sure you want to clear the current order?')) {
            cart = []; 
            renderCart(); 
        }
    }

    function filterByCategory(catId, btn) {
        document.querySelectorAll('.menu-item-row').forEach(row => {
            row.style.setProperty('display', (catId === 'all' || row.getAttribute('data-category') == catId) ? 'block' : 'none', 'important');
        });
        
        // Dynamic Switch Active State
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('btn-primary');
            b.classList.add('btn-outline-secondary');
        });
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-primary');
    }

    function filterItems() {
        let input = document.getElementById('itemSearch').value.toLowerCase();
        document.querySelectorAll('.menu-item-row').forEach(row => {
            let name = row.querySelector('h6').innerText.toLowerCase();
            row.style.setProperty('display', name.includes(input) ? 'block' : 'none', 'important');
        });
    }

    function toggleTableSelection() {
        let type = document.getElementById('order_type').value;
        document.getElementById('table-selection-div').style.display = (type === 'dine_in') ? 'block' : 'none';
    }

    function finalizeOrder() {
        if (cart.length === 0) {
            alert('Your cart is empty! Add items first.');
            return;
        }

        // Dine-In Safety Check Validation Added
        let orderType = document.getElementById('order_type').value;
        if(orderType === 'dine_in') {
            let tableId = document.getElementById('table_id').value;
            if(!tableId) {
                alert('Please select a Table Number for Dine-In order!');
                return;
            }
        }

        document.getElementById('cart_data').value = JSON.stringify(cart);
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('btnText').innerText = 'Processing...';
        document.getElementById('pos-form').submit();
    }

    window.onload = renderCart;
</script>
@endsection