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
            <div class="row">
                <div class="col-md-6 col-lg-8">
                    <form action="{{ route('katekisasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jemaat_id" value="{{ Auth::user()->id }}">
                        <table class="table table-borderless">
                            <tbody>
                                <!-- NIK Field -->
                                <tr>
                                    <td class="align-middle">NIK <b class="text-danger">*</b></td>
                                    <td class="align-middle">:</td>
                                    <td>
                                        @if (Auth::user()->profilJemaat && Auth::user()->profilJemaat->nik)
                                            <!-- Jika NIK sudah ada, tampilkan value dan disable form -->
                                            <input type="text" name="nik" id="nik" class="form-control"
                                                value="{{ Auth::user()->profilJemaat->nik }}" placeholder="NIK" disabled>
                                        @else
                                            <!-- Jika NIK belum ada, form bisa diisi -->
                                            <input type="text" name="nik" id="nik" class="form-control"
                                                placeholder="NIK">
                                        @endif

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
                                            value="{{ Auth::user()->profilJemaat->nama }}" class="form-control"
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
                                        <input type="text" name="jenis_kelamin" id="jenis_kelamin"
                                            value="{{ Auth::user()->profilJemaat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                            class="form-control" placeholder="Jenis Kelamin" disabled>
                                        @error('jenis_kelamin')
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
                                            placeholder="Tempat Lahir"
                                            value="{{ Auth::user()->profilJemaat->tempat_lahir }}" disabled>
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
                                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                            value="{{ \Carbon\Carbon::parse(Auth::user()->profilJemaat->tanggal_lahir)->isoFormat('D MMMM YYYY') }}"
                                            disabled>
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
                                            placeholder="Nama Ayah" value="{{ Auth::user()->profilJemaat->ayah }}"
                                            disabled>
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
                                            placeholder="Nama Ibu" value="{{ Auth::user()->profilJemaat->ibu }}" disabled>
                                        @error('ibu')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Wilayah -->
                                <tr>
                                    <td class="align-middle">Wilayah <b class="text-danger">*</b></td>
                                    <td class="align-middle">:</td>
                                    <td>
                                        <input type="text" name="wilayah_id" id="wilayah_id" class="form-control"
                                            placeholder="Wilayah" value="{{ Auth::user()->profilJemaat->wilayah->nama }}"
                                            disabled>
                                        @error('wilayah_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>

                                <!-- Jadwal Pelayanan -->
                                <tr>
                                    <td class="align-middle">Jadwal Pelayanan <b class="text-danger">*</b></td>
                                    <td class="align-middle">:</td>
                                    <td>
                                        <select name="jadwal_id" id="jadwal_id" class="form-control">
                                            @if ($jadwals->isEmpty() || $jadwals->every(fn($jadwal) => $jadwal->isExpired))
                                                <option disabled selected>Belum ada jadwal</option>
                                            @else
                                                <option value="">Pilih Jadwal</option>
                                                @foreach ($jadwals as $jadwal)
                                                    @if (!$jadwal->isExpired)
                                                        <option value="{{ $jadwal->id }}"
                                                            @if (old('jadwal_id') == $jadwal->id) selected @endif>
                                                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($jadwal->jam)->isoFormat('H:mm a') }}
                                                            ({{ $jadwal->pendeta->profilPendeta->nama }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('jadwal_id')
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
                                                    id="baptis_dewasa" @if (old('jenis_katekisasi') == 'Baptis Dewasa') checked @endif>
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

                                <!-- Akta Baptis -->
                                <tr>
                                    <td class="align-middle">Akta Baptis <b class="text-danger">*</b></td>
                                    <td class="align-middle">:</td>
                                    <td>
                                        <input type="file" name="akta_baptis" id="akta_baptis" class="form-control"
                                            required>
                                        @error('akta_baptis')
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
        </div>

    </section><!-- /Starter Section Section -->
@endsection
