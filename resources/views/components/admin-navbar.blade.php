<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/admin/products">
            Admin Panel
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="adminNavbar" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a href="/admin/products" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                        Produk
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/orders" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        Pesanan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/reports" class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                        Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}" class="nav-link text-danger">
                        Logout
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
