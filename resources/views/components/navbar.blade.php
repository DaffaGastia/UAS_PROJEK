<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            Mocha Jane
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                </li> -->
                <li class="nav-item">
                    <a href="/products" class="nav-link">Produk</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link">Keranjang</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('checkout.form') }}" class="nav-link">Checkout</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        Pesanan Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">Profil</a>
                </li>
                <li class="nav-item">
                    <a href="/chat-ai" class="nav-link">Chat AI</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link text-danger">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
