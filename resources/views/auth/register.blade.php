@extends('landing-page.layouts.app')

@section('content')
    <section class="bg-body-secondary d-flex align-items-center justify-content-center">
        <div class="register-box" style="width: 400px; margin-top: 30px; margin-bottom: 30px;">
            <div class="card">
                <div class="card-body register-card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" placeholder="Nama lengkap">
                            <div class="input-group-text"> <span class="bi bi-person"></span> </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Email">
                            <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Kata sandi">
                            <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> <!--begin::Row-->
                        <div class="input-group mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                placeholder="Konfirmasi kata sandi">
                            <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="form-check"> <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                        Tampilkan kata sandi</label> </div>
                            </div> <!-- /.col -->
                            <div class="col-4">
                                <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Daftar</button>
                                </div>
                            </div> <!-- /.col -->
                        </div> <!--end::Row-->
                    </form>

                    <p class="mb-0"> <a href="{{ route('login') }}" class="text-center">
                            Sudah punya akun? Login disini
                        </a> </p>
                </div> <!-- /.register-card-body -->
            </div>
        </div> <!-- /.register-box -->

        <!-- Include SweetAlert2 and other necessary scripts -->
        @include('sweetalert::alert')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
            integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
        <script src="{{ asset('adminLTE/js/adminlte.js') }}"></script>
    </section>
@endsection
