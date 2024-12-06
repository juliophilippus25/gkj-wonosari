@extends('landing-page.layouts.app')

@section('title', 'Daftar Akun')

@section('content')
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Pendaftaran Akun</h1>
        </div>
    </div><!-- End Page Title -->

    <section class="bg-body-secondary d-flex align-items-center justify-content-center">
        <div class="register-box" style="width: 800px; margin-top: 30px; margin-bottom: 30px;">
            <div class="card">
                <div class="card-body register-card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nik">NIK</label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="nik" type="text"
                                        class="form-control @error('nik') is-invalid @enderror" name="nik"
                                        value="{{ old('nik') }}" placeholder="NIK">
                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="nama">Nama Lengkap <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="nama" type="text"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        value="{{ old('nama') }}" placeholder="Nama lengkap">
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="email">Email <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp">No. Handphone <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="no_hp" type="text"
                                        class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                        value="{{ old('no_hp') }}" placeholder="No. Handphone">
                                    @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tempat_lahir">Tempat Lahir <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="tempat_lahir" type="text"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir"
                                        value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir">
                                    @error('tempat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir">Tanggal Lahir <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="tanggal_lahir" type="date"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ayah">Nama Ayah <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="ayah" type="text"
                                        class="form-control @error('ayah') is-invalid @enderror" name="ayah"
                                        value="{{ old('ayah') }}" placeholder="Nama Ayah">
                                    @error('ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ibu">Nama Ibu <b class="text-danger">*</b></label>
                                <div class="input-group mb-3">
                                    <input id="ibu" type="text"
                                        class="form-control @error('ibu') is-invalid @enderror" name="ibu"
                                        value="{{ old('ibu') }}" placeholder="Nama Ibu">
                                    @error('ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="jenis_kelamin">Jenis Kelamin <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1 flex gap-3">
                                    <label class="form-check-label">
                                        <input type="radio" name="jenis_kelamin" value="L" id="laki_laki"
                                            @if (old('jenis_kelamin') == 'L') checked @endif>
                                        Laki-laki
                                    </label>
                                    <label class="form-check-label">
                                        <input type="radio" name="jenis_kelamin" value="P" id="perempuan"
                                            @if (old('jenis_kelamin') == 'P') checked @endif>
                                        Perempuan
                                    </label>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="wilayah_id" class="form-label">Wilayah <b class="text-danger">*</b></label>
                                <select class="form-select @error('wilayah_id') is-invalid @enderror" name="wilayah_id"
                                    id="wilayah_id" required>
                                    <option hidden disabled selected value>Pilih wilayah</option>
                                    @foreach ($sortedWilayahs as $wilayah)
                                        <option value="{{ $wilayah->id }}">
                                            {{ $wilayah->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('wilayah_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="password">Password <b class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="password" name="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div> <!--begin::Row-->
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation">Konfirmasi Password <b
                                        class="text-danger">*</b></label>
                                <div class="input-group mb-3 mt-1">
                                    <input id="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Konfirmasi Password">
                                </div>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
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
