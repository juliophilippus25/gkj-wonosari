@extends('layouts.app')

@section('title', 'Pendaftaran')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('registrations.index') }}">Pendaftaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Pendaftaran</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <!-- Parent Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="parent_name" class="form-label">Nama Orang Tua</label>
                                    <input type="text" class="form-control" id="parent_name" value="{{ $user->name }}"
                                        placeholder="Masukkan nama" disabled>
                                </div>

                                <!-- Child Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror @if (old('name') && !$errors->has('name')) is-valid @endif"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Masukkan nama" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Gender Field -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <input type="radio" name="gender" value="M"
                                            @if (old('gender') == 'M') checked @endif> Laki-laki
                                        <input type="radio" name="gender" value="F"
                                            @if (old('gender') == 'F') checked @endif> Perempuan
                                    </div>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Date of Birth Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                    <input type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror @if (old('date_of_birth') && !$errors->has('date_of_birth')) is-valid @endif"
                                        id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Place of Birth Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="place_of_birth" class="form-label">Tempat Lahir</label>
                                    <input type="text"
                                        class="form-control @error('place_of_birth') is-invalid @enderror @if (old('place_of_birth') && !$errors->has('place_of_birth')) is-valid @endif"
                                        id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}"
                                        placeholder="Masukkan tempat lahir" required>
                                    @error('place_of_birth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Address Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text"
                                        class="form-control @error('address') is-invalid @enderror @if (old('address') && !$errors->has('address')) is-valid @endif"
                                        id="address" name="address" value="{{ old('address') }}"
                                        placeholder="Masukkan alamat" required>
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Region Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="region_id" class="form-label">Wilayah</label>
                                    <select
                                        class="form-select @error('region_id') is-invalid @enderror @if (old('region_id') && !$errors->has('region_id')) is-valid @endif"
                                        name="region_id" id="region_id" required>
                                        <option hidden disabled selected value>Pilih wilayah</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}"
                                                {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Birth certificate -->
                                <div class="col-md-6 mb-3">
                                    <label for="birth_certificate" class="form-label">Akta Lahir</label>
                                    <input type="file"
                                        class="form-control @error('birth_certificate') is-invalid @enderror @if (old('birth_certificate') && !$errors->has('birth_certificate')) is-valid @endif"
                                        name="birth_certificate" id="birth_certificate" required>
                                    @error('birth_certificate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Schedule Selection -->
                            <div class="mb-3">
                                <label for="schedule_id" class="form-label">Jadwal</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Layanan</th>
                                            <th>Petugas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($schedules->isEmpty() || $schedules->every(fn($schedule) => $schedule->isExpired))
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada jadwal</td>
                                            </tr>
                                        @else
                                            @foreach ($schedules as $schedule)
                                                @if (!$schedule->isExpired)
                                                    <tr>
                                                        <td>
                                                            <input type="radio" name="schedule_id"
                                                                value="{{ $schedule->id }}"
                                                                @if (old('schedule_id') == $schedule->id) checked @endif
                                                                onclick="selectSchedule(this)">
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, D MMMM YYYY') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}
                                                        </td>
                                                        <td>{{ $schedule->services->name }}</td>
                                                        <td>{{ $schedule->users->name }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @error('schedule_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        function selectSchedule(selectedRadio) {
            const radios = document.getElementsByName('schedule_id');
            for (const radio of radios) {
                if (radio !== selectedRadio) {
                    radio.checked = false;
                }
            }
        }
    </script>

@endsection

@endsection
