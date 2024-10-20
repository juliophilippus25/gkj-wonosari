@extends('layouts.app')

@section('title', 'Pendeta')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('pendeta.index') }}">Pendeta</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!-- Small Box (Stat card) -->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pendeta</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('pendeta.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror @if (old('name') && !$errors->has('name')) is-valid @endif"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan nama pendeta" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror @if (old('email') && !$errors->has('email')) is-valid @endif"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Masukkan email" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid @enderror @if (old('password') && !$errors->has('password')) is-valid @endif"
                                        id="password" name="password" placeholder="Masukkan kata sandi" required>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Password Confirmation Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror @if (old('password_confirmation') && !$errors->has('password_confirmation')) is-valid @endif"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Masukkan ulang kata sandi" required>
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Card Footer with Save and Cancel Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('pendeta.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div> <!-- /.row -->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
@endsection
