@extends('landing-page.layouts.app')

@section('title', 'Login')

@section('content')
    <section class="bg-body-secondary d-flex align-items-center justify-content-center">
        <div class="login-box" style="width: 400px; margin-top: 30px; margin-bottom: 30px;">
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3"> <input type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Email">
                            <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3"> <input type="password" name="password"
                                class="form-control  @error('password') is-invalid @enderror" placeholder="Kata sandi">
                            <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> <!--begin::Row-->
                        <div class="row">
                            <div class="col-8">
                                <div class="form-check"> <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                        Tampilkan kata sandi
                                    </label> </div>
                            </div> <!-- /.col -->
                            <div class="col-4">
                                <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Log in</button>
                                </div>
                            </div> <!-- /.col -->
                        </div> <!--end::Row-->
                    </form>
                    <p class="mb-0"> <a href="{{ route('register') }}" class="text-center">
                            Belum punya akun? Daftar disini
                        </a> </p>
                </div>
            </div> <!-- /.login-box --> <!--begin::Third Party Plugin(OverlayScrollbars)-->
            @include('sweetalert::alert')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
                integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
            <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
            <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
            <script src="{{ asset('adminLTE/js/adminlte.js') }}"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
            <script>
                const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
                const Default = {
                    scrollbarTheme: "os-theme-light",
                    scrollbarAutoHide: "leave",
                    scrollbarClickScroll: true,
                };
                document.addEventListener("DOMContentLoaded", function() {
                    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
                    if (
                        sidebarWrapper &&
                        typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
                    ) {
                        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                            scrollbars: {
                                theme: Default.scrollbarTheme,
                                autoHide: Default.scrollbarAutoHide,
                                clickScroll: Default.scrollbarClickScroll,
                            },
                        });
                    }
                });
            </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
            </body><!--end::Body-->
        @endsection
