@extends('backend.layouts.app')

@section('content')
<div class="pc-container" style="background-color: #f4f7fa; min-height: 100vh; padding-top: 75px;">
    <div class="pc-content">
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0 fw-bold text-dark">Menu Selection</h4>
                            <div class="input-group w-50 shadow-sm border rounded-pill overflow-hidden">
                                <span class="input-group-text bg-white border-0"><i class="ti ti-search text-muted"></i></span>
                                <input type="text" id="itemSearch" class="form-control border-0 ps-0" placeholder="Search dish name..." onkeyup="filterItems()">
                            </div>
                        </div>

                        <div class="d-flex gap-2 overflow-auto pb-3 custom-scrollbar" id="category-filters" style="white-space: nowrap;">
                            <button class="btn btn-primary rounded-pill btn-sm px-4 active-cat" onclick="filterByCategory('all', this)">All Items</button>
                            @foreach($categories as $cat)
                                <button class="btn btn-light rounded-pill btn-sm px-4 border" onclick="filterByCategory('{{ $cat->id }}', this)">{{ $cat->name }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-body p-3" style="height: calc(100vh - 280px); overflow-y: auto;">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xxl-4 g-3" id="itemsGrid">
                            @forelse($menuItems as $item)
                            <div class="col menu-item-container" data-category="{{ $item->category_id }}">
                                <div class="item-card shadow-sm" onclick="addToCart({{ $item->id }}, {{ json_encode($item->name) }}, {{ $item->price }})">
                                    <div class="img-box">
                                        @php $imgPath = 'uploads/menu_items/'.$item->image; @endphp
                                        @if($item->image && file_exists(public_path($imgPath)))
                                            <img src="{{ asset($imgPath) }}" alt="{{ $item->name }}">
                                        @else
                                            <div class="no-img">
                                                <i class="ti ti-tools-kitchen-2 fs-2 text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="price-badge">Rs {{ number_format($item->price, 0) }}</div>
                                    </div>
                                    <div class="item-details">
                                        <h6 class="item-name">{{ $item->name }}</h6>
                                        <p class="item-cat text-muted mb-0">{{ $item->category->name ?? 'General' }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <i class="ti ti-cookie-off text-muted" style="font-size: 4rem;"></i>
                                <h5 class="text-muted mt-3">No menu items added yet.</h5>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="ti ti-receipt me-2 text-primary"></i>Cart</h5>
                        <button class="btn btn-sm btn-light-danger rounded-pill" onclick="clearCart()">Clear</button>
                    </div>
                    
                    <div class="card-body p-0 d-flex flex-column" style="height: calc(100vh - 250px);">
                        <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                            <table class="table align-middle mb-0">
                                <tbody id="cart-items">
                                    </tbody>
                            </table>
                        </div>

                        <div class="p-4 bg-light border-top mt-auto">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Sub Total</span>
                                <span class="fw-bold" id="cart-subtotal">Rs 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Tax (5%)</span>
                                <span class="fw-bold text-danger" id="cart-tax">Rs 0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <h5 class="mb-0 fw-bold">Total</h5>
                                <h3 class="mb-0 fw-bold text-primary" id="cart-total">Rs 0</h3>
                            </div>
                        </div>

                        <form action="{{ route('admin.pos.store') }}" method="POST" id="pos-form" class="p-4 pt-0 bg-light">
                            @csrf
                            <input type="hidden" name="cart_data" id="cart_data">
                            
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <select name="order_type" id="order_type" class="form-select border-2" onchange="toggleTableSelection()">
                                        <option value="dine_in">🍽️ Dine-In</option>
                                        <option value="takeaway">🥡 Takeaway</option>
                                        <option value="delivery">🛵 Delivery</option>
                                    </select>
                                </div>
                                <div class="col-6" id="table-selection-div">
                                    <select name="table_id" id="table_id" class="form-select border-2">
                                        <option value="">Table #</option>
                                        @foreach($tables as $table)
                                            <option value="{{ $table->id }}">{{ $table->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mb-3">
                                <input type="radio" class="btn-check" name="payment_method" id="pay_cash" value="cash" checked>
                                <label class="btn btn-outline-success w-100 fw-bold" for="pay_cash">CASH</label>
                                <input type="radio" class="btn-check" name="payment_method" id="pay_card" value="card">
                                <label class="btn btn-outline-info w-100 fw-bold" for="pay_card">CARD</label>
                            </div>

                            <button type="button" onclick="finalizeOrder()" id="submitBtn" class="btn btn-primary w-100 py-3 rounded shadow-sm">
                                <span class="fw-bold h5 mb-0 text-white" id="btnText">PLACE ORDER</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fixed Height Card Styling */
    .item-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.2s, border-color 0.2s;
        height: 200px; /* Fixed card height */
        display: flex;
        flex-direction: column;
    }

    .item-card:hover {
        transform: translateY(-3px);
        border-color: #7267ef;
    }

    .img-box {
        position: relative;
        height: 120px; /* Fixed image area height */
        width: 100%;
        background: #f8f9fa;
        overflow: hidden;
    }

    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* This prevents vertical stretching */
    }

    .no-img {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
    }

    .price-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(114, 103, 239, 0.9);
        color: white;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 11px;
    }

    .item-details {
        padding: 10px;
        text-align: center;
    }

    .item-name {
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 2px;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis; /* Long name dot dot dot */
    }

    .item-cat {
        font-size: 11px;
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #7267ef; border-radius: 10px; }
</style>

<script>
    let cart = [];

    function addToCart(id, name, price) {
        let existingItem = cart.find(item => item.id === id);
        if(existingItem) {
            existingItem.quantity += 1;
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
            cartBody.innerHTML = '<tr><td class="text-center py-5 text-muted">Cart Empty</td></tr>';
        } else {
            cart.forEach((item, index) => {
                let total = item.price * item.quantity;
                subTotal += total;
                cartBody.innerHTML += `
                    <tr class="border-bottom">
                        <td class="ps-3 py-2">
                            <div class="fw-bold" style="font-size: 12px;">${item.name}</div>
                            <small class="text-muted">@ ${item.price}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center bg-light rounded px-1">
                                <button type="button" class="btn btn-sm p-0 px-2" onclick="updateQty(${index}, -1)">-</button>
                                <span class="mx-2 fw-bold" style="font-size:12px;">${item.quantity}</span>
                                <button type="button" class="btn btn-sm p-0 px-2" onclick="updateQty(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td class="text-end pe-3 fw-bold" style="font-size: 12px;">Rs ${total}</td>
                    </tr>`;
            });
        }

        let tax = subTotal * 0.05;
        document.getElementById('cart-subtotal').innerText = 'Rs ' + subTotal.toLocaleString();
        document.getElementById('cart-tax').innerText = 'Rs ' + tax.toLocaleString();
        document.getElementById('cart-total').innerText = 'Rs ' + (subTotal + tax).toLocaleString();
    }

    function updateQty(index, change) {
        cart[index].quantity += change;
        if(cart[index].quantity <= 0) cart.splice(index, 1);
        renderCart();
    }

    function clearCart() {
        if(confirm('Clear entire cart?')) { cart = []; renderCart(); }
    }

    function filterByCategory(catId, btn) {
        let items = document.getElementsByClassName('menu-item-container');
        Array.from(items).forEach(item => {
            item.style.display = (catId === 'all' || item.getAttribute('data-category') == catId) ? '' : 'none';
        });
        
        // Tab switching logic
        document.querySelectorAll('#category-filters .btn').forEach(b => b.classList.replace('btn-primary', 'btn-light'));
        btn.classList.replace('btn-light', 'btn-primary');
    }

    function filterItems() {
        let input = document.getElementById('itemSearch').value.toLowerCase();
        let items = document.getElementsByClassName('menu-item-container');
        Array.from(items).forEach(item => {
            let name = item.querySelector('.item-name').innerText.toLowerCase();
            item.style.display = name.includes(input) ? '' : 'none';
        });
    }

    function toggleTableSelection() {
        let type = document.getElementById('order_type').value;
        document.getElementById('table-selection-div').style.display = (type === 'dine_in') ? 'block' : 'none';
    }

    function finalizeOrder() {
        if (cart.length === 0) return alert('Cart is empty!');
        let type = document.getElementById('order_type').value;
        if(type === 'dine_in' && !document.getElementById('table_id').value) return alert('Please select a table!');

        document.getElementById('cart_data').value = JSON.stringify(cart);
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('btnText').innerText = 'Processing...';
        document.getElementById('pos-form').submit();
    }

    window.onload = renderCart;
</script>
@endsection