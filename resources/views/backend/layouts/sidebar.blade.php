<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ url('/dashboard') }}" class="b-brand text-primary">
        <img src="{{ asset('backend/assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        
        <li class="pc-item {{ Request::is('dashboard') ? 'active' : '' }}">
          <a href="{{ url('/dashboard') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <li class="pc-item {{ Request::routeIs('admin.pos.index') ? 'active' : '' }}">
          <a href="{{ route('admin.pos.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-device-desktop"></i></span>
            <span class="pc-mtext">POS Terminal</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Core Operations</label>
          <i class="ti ti-building-store"></i>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/orders*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-shopping-cart"></i></span>
            <span class="pc-mtext">Orders</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.orders.live') }}"><i class="ti ti-bell-ringing me-2"></i>Live Orders <span class="badge bg-danger rounded-circle ms-1">3</span></a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.kds.index') }}"><i class="ti ti-device-tv me-2"></i>Kitchen Display (KDS)</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.orders.dispatch') }}"><i class="ti ti-truck-delivery me-2"></i>Ready to Dispatch</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.orders.history') }}"><i class="ti ti-history me-2"></i>Order History</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/categories*', 'admin/menu-items*', 'admin/addons*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-tools-kitchen-2"></i></span>
            <span class="pc-mtext">Menu Setup</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.categories.index') }}"><i class="ti ti-category me-2"></i>Categories</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.menu-items.index') }}"><i class="ti ti-soup me-2"></i>All Food Items</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.addons.index') }}"><i class="ti ti-puzzle me-2"></i>Add-ons & Extras</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.deals.index') }}"><i class="ti ti-discount-2 me-2"></i>Deals & Combos</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/inventory*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
            <span class="pc-mtext">Inventory & Stock</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.inventory.raw-materials.index') }}"><i class="ti ti-box me-2"></i>Raw Materials</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.inventory.suppliers.index') }}"><i class="ti ti-truck me-2"></i>Suppliers</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.inventory.purchase-orders.index') }}"><i class="ti ti-file-invoice me-2"></i>Purchase Orders</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.inventory.wastage.index') }}"><i class="ti ti-trash me-2"></i>Wastage Log</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/tables*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-coffee"></i></span>
            <span class="pc-mtext">Dine-in & Tables</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.tables.floor-plans') }}"><i class="ti ti-apps me-2"></i>Floor Plans</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.tables.index') }}"><i class="ti ti-table me-2"></i>Table Management</a></li>
          </ul>
        </li>

        <li class="pc-item pc-caption">
          <label>Management</label>
          <i class="ti ti-users"></i>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/hr*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users"></i></span>
            <span class="pc-mtext">HR & Staff</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.hr.employees') }}"><i class="ti ti-id me-2"></i>Employee List</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.hr.roles') }}"><i class="ti ti-shield-lock me-2"></i>Roles & Permissions</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.hr.attendance') }}"><i class="ti ti-clock me-2"></i>Attendance</a></li>
            <li class="pc-item"><a href="{{ route('admin.hr.roles')}}">test</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/crm*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-check"></i></span>
            <span class="pc-mtext">CRM & Customers</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.crm.customers') }}"><i class="ti ti-users me-2"></i>Customer Database</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.crm.loyalty') }}"><i class="ti ti-medal me-2"></i>Loyalty Points</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.crm.feedback') }}"><i class="ti ti-message-2 me-2"></i>Feedback</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/finance*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-receipt"></i></span>
            <span class="pc-mtext">Finance & Accounts</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.finance.sales') }}"><i class="ti ti-report-money me-2"></i>Sales Register</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.finance.expenses') }}"><i class="ti ti-wallet me-2"></i>Daily Expenses</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.finance.taxes') }}"><i class="ti ti-percentage me-2"></i>Tax Setup</a></li>
          </ul>
        </li>

        <li class="pc-item pc-caption">
          <label>Analytics & System</label>
          <i class="ti ti-settings"></i>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/reports*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-chart-bar"></i></span>
            <span class="pc-mtext">Reports</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.reports.daily-sales') }}"><i class="ti ti-calendar-stats me-2"></i>Daily Sales (EOD)</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.reports.best-sellers') }}"><i class="ti ti-award me-2"></i>Best Sellers</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.reports.stock') }}"><i class="ti ti-package me-2"></i>Stock Report</a></li>
          </ul>
        </li>

        <li class="pc-item pc-hasmenu {{ Request::is('admin/settings*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-settings"></i></span>
            <span class="pc-mtext">Settings</span>
            <span class="pc-marrow"><i class="ti ti-chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.settings.general') }}"><i class="ti ti-info-circle me-2"></i>General Info</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.settings.payment') }}"><i class="ti ti-credit-card me-2"></i>Payment Gateways</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('admin.settings.printer') }}"><i class="ti ti-printer me-2"></i>Printer Setup</a></li>
          </ul>
        </li>
      </ul>

      <div class="card text-center">
        <div class="card-body">
          <img src="{{ asset('backend/assets/images/img-navbar-card.png') }}" alt="images" class="img-fluid mb-2">
          <h5>Upgrade To Pro</h5>
          <p>Get more features</p>
          <a href="#" target="_blank" class="btn btn-success btn-sm">Buy Now</a>
        </div>
      </div>
    </div>
  </div>
</nav>