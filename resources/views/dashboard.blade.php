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
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-3 col-6"> <!-- small box -->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>{{ $getJumlahJemaat }}</h3>
                                <p>Jumlah Jemaat</p>
                            </div>
                            <i class="bi bi-people-fill small-box-icon"></i>
                            <a href="{{ route('jemaat.index') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Selengkapnya <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div> <!-- ./col -->
                    <!-- More cards follow -->
                </div> <!-- /.row -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Jemaat Berdasarkan Jenis Kelamin</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Jemaat Berdasarkan Wilayah</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 285px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Wilayah</th>
                                            <th>Jumlah Jemaat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getJemaatPerWilayah as $item)
                                            <tr>
                                                <td>{{ $item['wilayah'] }}</td>
                                                <td>{{ $item['jumlah_jemaat'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>

                <div class="row">
                    @if (Auth::user()->role == 'admin')
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Jadwal Pelayanan di Bulan {{ \Carbon\Carbon::now()->monthName }}
                                        {{ date('Y') }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 285px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Pelayanan</th>
                                                <th>Pendeta</th>
                                                <th>Jumlah Pendaftar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getJadwalPelayanan as $jadwals)
                                                @foreach ($jadwals as $item)
                                                    <tr>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item['jadwal']->tanggal)->isoFormat('dddd, D MMMM YYYY') }},
                                                            {{ \Carbon\Carbon::parse($item['jadwal']->jam)->isoFormat('H:mm a') }}
                                                        </td>
                                                        <td>{{ $item['jadwal']->layanan->nama }}</td>
                                                        <td>{{ $item['jadwal']->pendeta->profilPendeta->nama }}
                                                        </td>
                                                        <td>{{ $item['jumlah_pendaftar'] }}</td>
                                                        <td>
                                                            <!-- Tautan atau tombol aksi, misalnya untuk melihat detail -->
                                                            <a href="{{ route('jadwal.show', $item['jadwal']->id) }}"
                                                                class="btn btn-primary btn-sm">Lihat</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    @elseif(Auth::user()->role == 'pendeta')
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Jadwal Pelayanan Anda di Bulan
                                        {{ \Carbon\Carbon::now()->monthName }}
                                        {{ date('Y') }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="max-height: 285px; min-height: 0px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Pelayanan</th>
                                                <th>Bahasa</th>
                                                <th>Jumlah Pendaftar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($getJadwalPelayananPendeta as $jadwals)
                                                @foreach ($jadwals as $item)
                                                    <tr>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item['jadwal']->tanggal)->isoFormat('dddd, D MMMM YYYY') }},
                                                            {{ \Carbon\Carbon::parse($item['jadwal']->jam)->isoFormat('H:mm a') }}
                                                        </td>
                                                        <td>{{ $item['jadwal']->layanan->nama }}</td>
                                                        <td>{{ $item['jadwal']->jenis_bahasa }}
                                                        </td>
                                                        <td>{{ $item['jumlah_pendaftar'] }}</td>
                                                        <td>
                                                            @if ($item['jadwal']->layanan->nama == 'Baptis')
                                                                <a href="{{ route('baptis.pendeta.show', $item['jadwal']->id) }}"
                                                                    class="btn btn-primary btn-sm">Lihat</a>
                                                            @elseif($item['jadwal']->layanan->nama == 'Katekisasi')
                                                                <a href="{{ route('katekisasi.pendeta.show', $item['jadwal']->id) }}"
                                                                    class="btn btn-primary btn-sm">Lihat</a>
                                                            @elseif($item['jadwal']->layanan->nama == 'Sidhi/Baptis Dewasa')
                                                                <a href="{{ route('sidhi.pendeta.show', $item['jadwal']->id) }}"
                                                                    class="btn btn-primary btn-sm">Lihat</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada jadwal
                                                        pelayanan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    @endif

                </div>
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

                    {{-- <!-- Card untuk Katekisasi -->
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
                    </div> <!-- ./col --> --}}
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
    @section('script')
        <script src="{{ asset('adminLTE/plugins/chart.js/Chart.min.js') }}"></script>
        <script>
            var dataLaki = @json($getJemaatLaki);
            var dataPerempuan = @json($getJemaatPerempuan);

            var dataJenisKelamin = {
                labels: [
                    'Laki-laki',
                    'Perempuan',
                ],
                datasets: [{
                    data: [dataLaki, dataPerempuan],
                    backgroundColor: ['#3B82F6', '#F9A8D4'],
                }]
            }

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = dataJenisKelamin;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        </script>
    @endsection
@endsection
