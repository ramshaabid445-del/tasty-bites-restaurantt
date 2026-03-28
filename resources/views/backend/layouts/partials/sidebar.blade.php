<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                <img src="{{ asset('backend/assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                
                <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item {{ request()->routeIs('admin.pos.*') ? 'active' : '' }}">
                    <a href="{{ Route::has('admin.pos.index') ? route('admin.pos.index') : '#' }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-device-desktop"></i></span>
                        <span class="pc-mtext">POS Terminal</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Core Operations</label>
                    <i class="ti ti-building-store"></i>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/orders*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-shopping-cart"></i></span>
                        <span class="pc-mtext">Orders</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.orders.live') ? route('admin.orders.live') : '#' }}"><i class="ti ti-bell-ringing me-2"></i>Live / New Orders <span class="badge bg-danger rounded-circle ms-1">3</span></a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.kds.index') ? route('admin.kds.index') : '#' }}"><i class="ti ti-device-tv me-2"></i>Kitchen Display (KDS)</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.orders.dispatch') ? route('admin.orders.dispatch') : '#' }}"><i class="ti ti-truck-delivery me-2"></i>Ready to Dispatch</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.orders.history') ? route('admin.orders.history') : '#' }}"><i class="ti ti-history me-2"></i>Order History</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/menu*') || request()->is('admin/categories*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-tools-kitchen-2"></i></span>
                        <span class="pc-mtext">Menu Setup</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : '#' }}"><i class="ti ti-category me-2"></i>Categories</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.menu.index') ? route('admin.menu.index') : '#' }}"><i class="ti ti-soup me-2"></i>All Food Items</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.addons.index') ? route('admin.addons.index') : '#' }}"><i class="ti ti-puzzle me-2"></i>Add-ons & Extras</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.deals.index') ? route('admin.deals.index') : '#' }}"><i class="ti ti-discount-2 me-2"></i>Deals & Combos</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/inventory*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                        <span class="pc-mtext">Inventory & Stock</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.inventory.raw-materials.index') ? route('admin.inventory.raw-materials.index') : '#' }}"><i class="ti ti-box me-2"></i>Raw Materials</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.inventory.suppliers.index') ? route('admin.inventory.suppliers.index') : '#' }}"><i class="ti ti-truck me-2"></i>Suppliers / Vendors</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.inventory.purchase-orders.index') ? route('admin.inventory.purchase-orders.index') : '#' }}"><i class="ti ti-file-invoice me-2"></i>Purchase Orders</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.inventory.wastage.index') ? route('admin.inventory.wastage.index') : '#' }}"><i class="ti ti-trash me-2"></i>Wastage Log</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/tables*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-coffee"></i></span>
                        <span class="pc-mtext">Dine-in & Tables</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.tables.floor-plans') ? route('admin.tables.floor-plans') : '#' }}"><i class="ti ti-layout-board me-2"></i>Floor Plans</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.tables.index') ? route('admin.tables.index') : '#' }}"><i class="ti ti-table me-2"></i>Table Management</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-caption">
                    <label>Management</label>
                    <i class="ti ti-users"></i>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/hr*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">HR & Staff</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.hr.employees') ? route('admin.hr.employees') : '#' }}"><i class="ti ti-id me-2"></i>Employee List</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.hr.permissions') ? route('admin.hr.permissions') : '#' }}"><i class="ti ti-shield-lock me-2"></i>Roles & Permissions</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.hr.attendance') ? route('admin.hr.attendance') : '#' }}"><i class="ti ti-clock me-2"></i>Attendance & Shifts</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/crm*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                        <span class="pc-mtext">CRM & Customers</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.crm.index') ? route('admin.crm.index') : '#' }}"><i class="ti ti-users-group me-2"></i>Customer Database</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.crm.loyalty') ? route('admin.crm.loyalty') : '#' }}"><i class="ti ti-star me-2"></i>Loyalty Points</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.crm.feedback') ? route('admin.crm.feedback') : '#' }}"><i class="ti ti-message-star me-2"></i>Feedback & Reviews</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/finance*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-wallet"></i></span>
                        <span class="pc-mtext">Finance & Accounts</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.finance.sales') ? route('admin.finance.sales') : '#' }}"><i class="ti ti-receipt-2 me-2"></i>Sales Register</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.finance.expenses') ? route('admin.finance.expenses') : '#' }}"><i class="ti ti-cash me-2"></i>Daily Expenses</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.finance.taxes') ? route('admin.finance.taxes') : '#' }}"><i class="ti ti-receipt-tax me-2"></i>Tax Setup</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-caption">
                    <label>Analytics & System</label>
                    <i class="ti ti-settings"></i>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/reports*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-report-analytics"></i></span>
                        <span class="pc-mtext">Reports</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.reports.sales') ? route('admin.reports.sales') : '#' }}"><i class="ti ti-calendar-stats me-2"></i>Daily Sales (EOD)</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.reports.best-sellers') ? route('admin.reports.best-sellers') : '#' }}"><i class="ti ti-award me-2"></i>Best Sellers</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.reports.inventory') ? route('admin.reports.inventory') : '#' }}"><i class="ti ti-chart-bar me-2"></i>Stock & Inventory</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu {{ request()->is('admin/settings*') ? 'active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-settings"></i></span>
                        <span class="pc-mtext">Settings</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.settings.general') ? route('admin.settings.general') : '#' }}"><i class="ti ti-info-circle me-2"></i>General Info</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.settings.payments') ? route('admin.settings.payments') : '#' }}"><i class="ti ti-credit-card me-2"></i>Payment Gateways</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ Route::has('admin.settings.printers') ? route('admin.settings.printers') : '#' }}"><i class="ti ti-printer me-2"></i>Printer Configuration</a></li>
                    </ul>
                </li>
            </ul>

            <div class="card text-center bg-light-primary border-0 shadow-none m-3">
                <div class="card-body p-3">
                    <p class="mb-2 text-muted" style="font-size: 12px;">Restaurant OS v2.0</p>
                    <span class="badge bg-primary">Industrial Pro</span>
                </div>
            </div>
        </div>
    </div>
</nav>