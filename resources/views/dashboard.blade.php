@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->

    <div class="app-content"> <!--begin::Container-->
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pendeta')
            <div class="container-fluid"> <!-- Small Box (Stat card) -->
                <div class="row">
                    <div class="col-lg-3 col-6"> <!-- small box -->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>150</h3>
                                <p>New Orders</p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                                </path>
                            </svg>
                            <a href="#"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div> <!-- ./col -->
                    <!-- More cards follow -->
                </div> <!-- /.row -->
            </div> <!--end::Container-->
        @elseif(Auth::user()->role == 'jemaat')
            <div class="container-fluid"> <!-- Small Box (Stat card) -->

                @if ($ditolakBaptis && !$pendaftaranBaptisBaru)
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"> Peringatan!</i>
                        Pendaftaran baptis Anda ditolak dengan catatan <strong>"{{ $ditolakBaptis->catatan }}"</strong>.
                        Silahkan mendaftar
                        lagi
                        <a href="{{ route('baptis') }}" class="text-decoration-none">klik disini.</a>
                    </div>
                @endif

                @if ($ditolakSidhi && !$pendaftaranSidhiBaru)
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"> Peringatan!</i>
                        Pendaftaran sidhi/baptis dewasa Anda ditolak dengan catatan
                        <strong>"{{ $ditolakSidhi->catatan }}"</strong>. Silahkan
                        mendaftar lagi
                        <a href="{{ route('sidhi') }}" class="text-decoration-none">klik disini.</a>
                    </div>
                @endif

                @if ($ditolakKatekisasi && !$pendaftaranKatekisasiBaru)
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"> Peringatan!</i>
                        Pendaftaran katekisasi Anda ditolak dengan catatan
                        <strong>"{{ $ditolakKatekisasi->catatan }}"</strong>. Silahkan
                        mendaftar lagi
                        <a href="{{ route('katekisasi') }}" class="text-decoration-none">klik disini.</a>
                    </div>
                @endif

                <div class="row">
                    <!-- Card untuk Baptis -->
                    <div class="col-lg-4 col-6"> <!-- small box -->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>Baptis</h3>
                                <p>
                                    {{ $getSuratBaptis ? \Carbon\Carbon::parse($getSuratBaptis->jadwal?->tanggal)->isoFormat('dddd, D MMMM YYYY') : 'Belum ada surat baptis' }}
                                </p>
                            </div>
                            <i class="small-box-icon bi bi-envelope"></i>
                            @if ($getSuratBaptis === null)
                                <div
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    @if ($diprosesBaptis)
                                        Baptis sedang diproses
                                    @else
                                        <a href="{{ route('baptis') }}" class="text-decoration-none">
                                            Silahkan daftar baptis
                                        </a>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('jadwal.pdf', $getSuratBaptis->id) }}"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                    target="_blank">
                                    Unduh <i class="bi bi-download"></i>
                                </a>
                            @endif
                        </div>
                    </div> <!-- ./col -->

                    <!-- Card untuk Sidhi -->
                    <div class="col-lg-4 col-6"> <!-- small box -->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3>Sidhi</h3>
                                <p>
                                    {{ $getSuratSidhi ? \Carbon\Carbon::parse($getSuratSidhi->jadwal?->tanggal)->isoFormat('dddd, D MMMM YYYY') : 'Belum ada surat sidhi' }}
                                </p>
                            </div>
                            <i class="small-box-icon bi bi-envelope"></i>
                            @if ($getSuratSidhi === null)
                                <div
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    @if ($diprosesSidhi)
                                        Sidhi sedang diproses
                                    @else
                                        <a href="{{ route('sidhi') }}" class="text-decoration-none">
                                            Silahkan daftar sidhi
                                        </a>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('jadwal.pdf', $getSuratSidhi->id) }}"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                    target="_blank">
                                    Unduh <i class="bi bi-download"></i>
                                </a>
                            @endif
                        </div>
                    </div> <!-- ./col -->

                    <!-- Card untuk Katekisasi -->
                    <div class="col-lg-4 col-6"> <!-- small box -->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3>Katekisasi</h3>
                                <p>
                                    {{ $getSuratKatekisasi ? \Carbon\Carbon::parse($getSuratKatekisasi->jadwal?->tanggal)->isoFormat('dddd, D MMMM YYYY') : 'Belum ada surat katekisasi' }}
                                </p>
                            </div>
                            <i class="small-box-icon bi bi-envelope"></i>
                            @if ($getSuratKatekisasi === null)
                                <div
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    @if ($diprosesKatekisasi)
                                        Katekisasi sedang diproses
                                    @else
                                        <a href="{{ route('katekisasi') }}" class="text-decoration-none">
                                            Silahkan daftar katekisasi
                                        </a>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('jadwal.pdf', $getSuratKatekisasi->id) }}"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                    target="_blank">
                                    Unduh <i class="bi bi-download"></i>
                                </a>
                            @endif
                        </div>
                    </div> <!-- ./col -->
                </div> <!-- /.row -->

                @if ($suratKehadiran != null && !$isTidakHadirKatekisasi)
                    <p>
                        Unduh kartu kehadiran katekisasi:
                        <a href="{{ route('kartuKehadiranPDF', Auth::user()->id) }}" target="_blank">Unduh</a>
                    </p>
                @elseif ($isTidakHadirKatekisasi)
                    <p class="text-danger">
                        Anda tidak hadir pada katekisasi
                        <strong>{{ \Carbon\Carbon::parse($katekisasiTidakHadir->jadwal->tanggal)->isoFormat('D MMMM YYYY') }}</strong>.
                        Silahkan mendaftar
                        pada periode berikutnya.
                    </p>
                @endif
            </div>
        @endif
    </div>
    <!--end::Container-->
@endsection
