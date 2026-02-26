<!-- Sidebar Menu -->
<div class="p-3">
    <h1 class="navbar-brand navbar-brand-autodark text-center mb-4">
        <a href=".">
            <img src="{{ asset('assets/image2/CNC_LOGO.webp') }}" width="110" height="110" alt="Logo" class="navbar-brand-image">
        </a>
    </h1>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="#">
                <i class="fa fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.categories.index') }}">
                <i class="fa fa-list me-2"></i> Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.units.index') }}">
                <i class="fa fa-balance-scale me-2"></i> Unit
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.products.index') }}">
                <i class="fa fa-box me-2"></i> Product
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.vendors.index') }}">
                <i class="fa fa-store me-2"></i> Vendor
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.purchases.index') }}">
                <i class="fa fa-cart-plus me-2"></i> Purchase (GRN)
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.purchase-returns.index') }}">
                <i class="fa fa-undo me-2"></i> Purchase Returns
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.purchase-orders.index') }}">
                <i class="fa fa-file-invoice me-2"></i> Purchase Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.customers.index') }}">
                <i class="fa fa-users me-2"></i> Customers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.sales-orders.index') }}">
                <i class="fa fa-receipt me-2"></i> Sales Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.sales-invoices.index') }}">
                <i class="fa fa-file-invoice me-2"></i> Sales Invoices
            </a>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link text-white" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt me-2"></i> Log Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
