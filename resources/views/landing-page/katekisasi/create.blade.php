@extends('landing-page.layouts.app')

@section('title', 'Pendaftaran Katekisasi')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Katekisasi</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('katekisasi') }}">Katekisasi</a></li>
                    <li class="current">Pendaftaran</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="starter-section" class="starter-section section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Pendaftaran Katekisasi</h2>
            <p>Lengkapi dan isi formulir di bawah ini</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <form action="#" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-8">
                        <form>
                            <table class="table table-borderless">
                                <tbody>
                                    <!-- NIK Field -->
                                    <tr>
                                        <td class="w-25 align-middle">NIK</td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <input type="text" name="nik" id="nik" class="form-control"
                                                placeholder="NIK">
                                            @error('nik')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Nama Lengkap -->
                                    <tr>
                                        <td class="align-middle">Nama Lengkap <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <input type="text" name="name" id="name"
                                                value="{{ Auth::user()->name }}" class="form-control"
                                                placeholder="Nama Lengkap" disabled>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Jenis Kelamin -->
                                    <tr>
                                        <td class="align-middle">Jenis Kelamin <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <label class="form-check-label">
                                                    <input type="radio" name="gender" value="M" id="gender_m"
                                                        @if (old('gender') == 'M') checked @endif>
                                                    Laki-laki
                                                </label>
                                                <label class="form-check-label">
                                                    <input type="radio" name="gender" value="F" id="gender_f"
                                                        @if (old('gender') == 'F') checked @endif>
                                                    Perempuan
                                                </label>
                                            </div>
                                            @error('gender')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Tempat Lahir -->
                                    <tr>
                                        <td class="align-middle">Tempat Lahir <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                                placeholder="Tempat Lahir" required>
                                            @error('tempat_lahir')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Tanggal Lahir -->
                                    <tr>
                                        <td class="align-middle">Tanggal Lahir <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                                class="form-control" required>
                                            @error('tanggal_lahir')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Nama Ayah -->
                                    <tr>
                                        <td class="align-middle">Nama Ayah <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <input type="text" name="ayah" id="ayah" class="form-control"
                                                placeholder="Nama Ayah" required>
                                            @error('ayah')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Nama Ibu -->
                                    <tr>
                                        <td class="align-middle">Nama Ibu <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <input type="text" name="ibu" id="ibu" class="form-control"
                                                placeholder="Nama Ibu" required>
                                            @error('ibu')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Jadwal Pelayanan -->
                                    <tr>
                                        <td class="align-middle">Jadwal Pelayanan <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <select name="schedule_id" id="schedule_id" class="form-control">
                                                @if ($schedules->isEmpty() || $schedules->every(fn($schedule) => $schedule->isExpired))
                                                    <option disabled selected>Belum ada jadwal</option>
                                                @else
                                                    <option value="">Pilih Jadwal</option>
                                                    @foreach ($schedules as $schedule)
                                                        @if (!$schedule->isExpired)
                                                            <option value="{{ $schedule->id }}"
                                                                @if (old('schedule_id') == $schedule->id) selected @endif>
                                                                {{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, D MMMM YYYY') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}
                                                                -
                                                                {{ $schedule->services->name }}
                                                                ({{ $schedule->users->name }})
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('schedule_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>

                                    <!-- Jenis Katekisasi -->
                                    <tr>
                                        <td class="align-middle">Jenis Katekisasi <b class="text-danger">*</b></td>
                                        <td class="align-middle">:</td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                <label class="form-check-label">
                                                    <input type="radio" name="jenis_katekisasi" value="Baptis Dewasa"
                                                        id="baptis_dewasa"
                                                        @if (old('jenis_katekisasi') == 'Baptis Dewasa') checked @endif>
                                                    Baptis Dewasa
                                                </label>
                                                <label class="form-check-label">
                                                    <input type="radio" name="jenis_katekisasi" value="Katekisasi"
                                                        id="katekisasi" @if (old('jenis_katekisasi') == 'Katekisasi') checked @endif>
                                                    Katekisasi
                                                </label>
                                            </div>
                                            @error('jenis_katekisasi')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn"
                                style="background-color: #3498db; color: white;">Daftar</button>
                        </form>
                    </div>
                </div>


            </form>
        </div>

    </section><!-- /Starter Section Section -->
@endsection
