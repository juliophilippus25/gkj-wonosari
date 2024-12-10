<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('imgs/logo.png') }}" alt="GKJ Wonosari">
            <h1 class="sitename">{{ config('app.name') }}</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('lp.jadwal') }}"
                        class="{{ request()->routeIs('lp.jadwal*') ? 'active' : '' }}">Jadwal
                        Pelayanan</a></li>
                <li class="dropdown"><a href="#"
                        class="{{ request()->routeIs('baptis*', 'sidhi*', 'katekisasi*') ? 'active' : '' }}"><span>Layanan</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ route('baptis') }}">Baptis</a></li>
                        <li><a href="{{ route('sidhi') }}">Sidhi/Baptis Dewasa</a></li>
                        <li><a href="{{ route('katekisasi') }}">Katekisasi</a></li>
                    </ul>
                </li>
                @auth
                    <li class="dropdown">
                        <a href="#">
                            <span>
                                @if (auth()->user()->role == 'admin')
                                    {{ auth()->user()->profilAdmin->nama }}
                                @elseif(auth()->user()->role == 'jemaat')
                                    {{ auth()->user()->profilJemaat->nama }}
                                @elseif(auth()->user()->role == 'pendeta')
                                    {{ auth()->user()->profilPendeta->nama }}
                                @endif
                            </span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"">Logout</a>
                            </li>
                        </ul>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <li><a href="{{ route('register') }}"
                            class="{{ request()->routeIs('register') ? 'active' : '' }}">Daftar</a></li>
                    <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                    </li>
                @endauth
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
