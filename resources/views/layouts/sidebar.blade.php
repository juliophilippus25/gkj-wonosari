<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link-->
        <a href="../index.html" class="brand-link"> <!--begin::Brand Image-->
            {{-- <img src="../../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text-->  --}}
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
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"> <i
                                class="nav-icon bi bi-people"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
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

                @if (Auth::user()->role == 'user')
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>
                                Pendaftaran
                            </p>
                        </a>
                    </li>
                @endif
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
