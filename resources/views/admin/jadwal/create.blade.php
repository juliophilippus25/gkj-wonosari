@extends('layouts.app')

@section('title', 'Jadwal')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('jadwal.index') }}">Jadwal</a>
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
                        <h3 class="card-title">Tambah Jadwal</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('jadwal.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date"
                                        class="form-control @error('tanggal') is-invalid @enderror @if (old('tanggal') && !$errors->has('tanggal')) is-valid @endif"
                                        id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jam" class="form-label">Jam</label>
                                    <input type="time"
                                        class="form-control @error('jam') is-invalid @enderror @if (old('jam') && !$errors->has('jam')) is-valid @endif"
                                        id="jam" name="jam" value="{{ old('jam') }}" required>
                                    @error('jam')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="layanan" class="form-label">Pelayanan</label>
                                    <select
                                        class="form-select @error('layanan_id') is-invalid @enderror @if (old('layanan_id') && !$errors->has('layanan_id')) is-valid @endif"
                                        name="layanan_id" id="layanan_id">
                                        <option hidden disabled selected value>Pilih pelayanan</option>
                                        @foreach ($layanans as $layanan)
                                            <option value="{{ $layanan->id }}"
                                                {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                                {{ $layanan->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pendeta_id" class="form-label">Pendeta</label>
                                    <select
                                        class="form-select @error('pendeta_id') is-invalid @enderror @if (old('pendeta_id') && !$errors->has('pendeta_id')) is-valid @endif"
                                        name="pendeta_id" id="pendeta_id">
                                        <option hidden disabled selected value>Pilih pendeta</option>
                                        @forelse ($pendetas as $pendeta)
                                            <option value="{{ $pendeta->id }}"
                                                {{ old('pendeta_id') == $pendeta->id ? 'selected' : '' }}>
                                                {{ $pendeta->profilPendeta->nama }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Tidak ada pendeta yang tersedia</option>
                                        @endforelse
                                    </select>

                                    @error('pendeta_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>


                </div>
            </div> <!-- /.row -->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
@endsection