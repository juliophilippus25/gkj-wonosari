<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link-->
        <a href="../index.html" class="brand-link"> <!--begin::Brand Image-->
            <img src="{{ asset('imgs/logo.png') }}" alt="GKJ Wonosari Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image--> <!--begin::Brand Text-->
            <span class="brand-text fw-light">GKJ Wonosari</span> <!--end::Brand Text-->
        </a> <!--end::Brand Link-->
    </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"> <i
                            class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"> <i
                            class="nav-icon bi bi-house"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item {{ request()->is('jemaat*', 'pendeta*') ? 'menu-open' : '' }}"> <a
                            href="#" class="nav-link"> <i class="nav-icon bi bi-people"></i>
                            <p>
                                Pengguna
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"> <a href="{{ route('jemaat.index') }}"
                                    class="nav-link {{ request()->routeIs('jemaat.index') ? 'active' : '' }}"> <i
                                        class="nav-icon bi bi-circle"></i>
                                    <p>Jemaat</p>
                                </a> </li>
                            <li class="nav-item"> <a href="{{ route('pendeta.index') }}"
                                    class="nav-link {{ request()->routeIs('pendeta*') ? 'active' : '' }}"> <i
                                        class="nav-icon bi bi-circle"></i>
                                    <p>Pendeta</p>
                                </a> </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('schedules.index') }}"
                            class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}"> <i
                                class="nav-icon bi bi-calendar-event"></i>
                            <p>
                                Jadwal
                            </p>
                        </a>
                    </li>
                @endif

                {{-- @if (Auth::user()->role == 'jemaat')
                    <li class="nav-item">
                        <a href="{{ route('home') }}"
                            class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"> <i
                                class="nav-icon bi bi-house"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('registrations.index') }}"
                            class="nav-link {{ request()->routeIs('registrations.*') ? 'active' : '' }}"> <i
                                class="nav-icon bi bi-person-lines-fill"></i>
                            <p>
                                Pendaftaran
                            </p>
                        </a>
                    </li>
                @endif --}}

                @if (Auth::user()->role == 'pendeta')
                    <li class="nav-item">
                        <a href="{{ route('service.index') }}"
                            class="nav-link {{ request()->routeIs('service.*') ? 'active' : '' }}"> <i
                                class="nav-icon bi bi-person-lines-fill"></i>
                            <p>
                                Pelayanan
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"
                        class="nav-link"> <i class="nav-icon bi bi-power"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
