<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">{{ config('app.name') }}</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/" class="{{ request()->routeIs('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="#jadwal-pelayanan">Jadwal Pelayanan</a></li>
                <li><a href="#services">Pengumuman</a></li>
                <li class="dropdown"><a href="#"><span>Layanan</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Baptis</a></li>
                        <li><a href="#">Sidhi/Baptis Dewasa</a></li>
                        <li><a href="#">Katekisasi</a></li>
                    </ul>
                </li>
                <li><a href="#contact">Kontak</a></li>
                <li><a href="{{ route('register') }}"
                        class="{{ request()->routeIs('register') ? 'active' : '' }}">Daftar</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="header-social-links">
            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>

    </div>
</header>
