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
                            <a href="{{ route('schedules.index') }}">Jadwal</a>
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
                        <form action="{{ route('schedules.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input type="date"
                                        class="form-control @error('date') is-invalid @enderror @if (old('date') && !$errors->has('date')) is-valid @endif"
                                        id="date" name="date" value="{{ old('date') }}" required>
                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="time" class="form-label">Jam</label>
                                    <input type="time"
                                        class="form-control @error('time') is-invalid @enderror @if (old('time') && !$errors->has('time')) is-valid @endif"
                                        id="time" name="time" value="{{ old('time') }}" required>
                                    @error('time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="service" class="form-label">Pelayanan</label>
                                    <select
                                        class="form-select @error('service_id') is-invalid @enderror @if (old('service_id') && !$errors->has('service_id')) is-valid @endif"
                                        name="service_id" id="service_id">
                                        <option hidden disabled selected value>Pilih pelayanan</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="service" class="form-label">Pendeta</label>
                                    <select
                                        class="form-select @error('pendeta_id') is-invalid @enderror @if (old('pendeta_id') && !$errors->has('pendeta_id')) is-valid @endif"
                                        name="pendeta_id" id="pendeta_id">
                                        <option hidden disabled selected value>Pilih pendeta</option>
                                        @forelse ($pendetas as $pendeta)
                                            <option value="{{ $pendeta->id }}"
                                                {{ old('pendeta_id') == $pendeta->id ? 'selected' : '' }}>
                                                {{ $pendeta->name }}
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
                                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>


                </div>
            </div> <!-- /.row -->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
@endsection
