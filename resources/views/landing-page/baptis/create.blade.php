@extends('landing-page.layouts.app')

@section('title', 'Pendaftaran Baptis')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Baptis</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('baptis') }}">Baptis</a></li>
                    <li class="current">Pendaftaran</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="starter-section" class="starter-section section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Pendaftaran Baptis</h2>
            <p>Lengkapi dan isi formulir di bawah ini</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <form action="#" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK">
                        </div>
                        <div class="mb-3">
                            <label for="name">Nama Lengkap <b class="text-danger">*</b></label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                                class="form-control" placeholder="Nama Lengkap" disabled>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir">Tempat Lahir <b class="text-danger">*</b></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                        placeholder="Tempat Lahir" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir">Tanggal Lahir <b class="text-danger">*</b></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ayah">Nama Ayah <b class="text-danger">*</b></label>
                            <input type="text" name="ayah" id="ayah" class="form-control" placeholder="Nama Ayah"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="ibu">Nama Ibu <b class="text-danger">*</b></label>
                            <input type="text" name="ibu" id="ibu" class="form-control" placeholder="Nama Ibu"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="schedule_id">Jadwal Pelayanan <b class="text-danger">*</b></label>
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
                                                {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} -
                                                {{ $schedule->services->name }} ({{ $schedule->users->name }})
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn" style="background-color: #3498db; color: white;">Daftar</button>
            </form>
        </div>

    </section><!-- /Starter Section Section -->
@endsection
