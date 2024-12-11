<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->

        <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
            <li class="nav-item dropdown user-menu">
                <span class="d-none d-md-inline">
                    @if (auth()->user()->role == 'admin')
                        {{ auth()->user()->profilAdmin->nama }}
                    @elseif(auth()->user()->role == 'jemaat')
                        {{ auth()->user()->profilJemaat->nama }}
                    @elseif(auth()->user()->role == 'pendeta')
                        {{ auth()->user()->profilPendeta->nama }}
                    @endif
                </span>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        {{-- <img src="../../../dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image"> --}}
                        <p>
                            @if (auth()->user()->role == 'admin')
                                {{ auth()->user()->profilAdmin->nama }}
                            @elseif(auth()->user()->role == 'jemaat')
                                {{ auth()->user()->profilJemaat->nama }}
                            @elseif(auth()->user()->role == 'pendeta')
                                {{ auth()->user()->profilPendeta->nama }}
                            @endif
                        </p>
                    </li> <!--end::User Image--> <!--begin::Menu Body-->
                    {{-- <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"
                            class="btn btn-default btn-flat float-end">
                            Log out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li> <!--end::Menu Footer--> --}}
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->

    </div> <!--end::Container-->
</nav> <!--end::Header-->
