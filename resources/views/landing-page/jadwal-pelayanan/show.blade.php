@extends('landing-page.layouts.app')

@section('title', 'Jadwal Pelayanan')

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Pelayanan {{ $jadwal->layanan->nama }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('lp.jadwal') }}">Jadwal Pelayanan</a></li>
                    <li class="current">Pelayanan {{ $jadwal->layanan->nama }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="starter-section" class="services section">

        <div class="container" data-aos="fade-up">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Pelayanan {{ $jadwal->layanan->nama }}</h2>
            </div><!-- End Section Title -->

            <div>
                <table class="table table-borderless mb-4">
                    <tbody>
                        <tr>
                            <td style="width: 25%;" class="fw-bold">Pendeta</td>
                            <td style="width: 0%;">:</td>
                            <td>{{ $jadwal->pendeta->profilPendeta->nama }}</td>
                        </tr>
                        <tr>
                            <td style="width: 10%;" class="fw-bold">Waktu Pelaksanaan</td>
                            <td style="width: 0%;">:</td>
                            <td>
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }},
                                {{ \Carbon\Carbon::parse($jadwal->jam)->isoFormat('H:mm a') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;" class="fw-bold">Jenis Bahasa</td>
                            <td style="width: 0%;">:</td>
                            <td>
                                {{ $jadwal->jenis_bahasa }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;" class="fw-bold">Jumlah Pendaftar</td>
                            <td style="width: 0%;">:</td>
                            <td>
                                {{ $jadwal->jumlah_pendaftar }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;" class="fw-bold">Status</td>
                            <td style="width: 0%;">:</td>
                            <td>
                                <span class="{{ $jadwal->isExpired ? 'badge bg-success' : 'badge bg-warning' }}">
                                    {{ $jadwal->isExpired ? 'Sudah Dilaksanakan' : 'Belum Dilaksanakan' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftars as $pendaftar)
                            <tr>
                                <td>{{ $pendaftar->profilJemaat->nama }}</td>
                                <td>
                                    @if ($pendaftar->status_verifikasi == 'Diproses')
                                        <span class="badge bg-warning">Diproses</span>
                                    @elseif ($pendaftar->status_verifikasi == 'Disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($pendaftar->status_verifikasi == 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section><!-- /Starter Section Section -->

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                searching: true, // Aktifkan pencarian
                paging: true, // Aktifkan pagination
                pageLength: 10, // Jumlah data per halaman
                language: {
                    search: "Cari", // Label pencarian
                    searchPlaceholder: "Cari {{ $dataType }}", // Placeholder pencarian
                    lengthMenu: "Tampilkan _MENU_ data per halaman", // Menu jumlah data per halaman
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ {{ $dataType }}", // Info pagination
                    infoEmpty: "Tidak ada {{ $dataType }} yang tersedia", // Pesan saat tidak ada data
                    infoFiltered: "(difilter dari _MAX_ total data)", // Pesan saat data difilter
                    zeroRecords: "Tidak ada {{ $dataType }} yang ditemukan.", // Pesan saat tidak ada hasil
                    emptyTable: "Tidak ada {{ $dataType }} yang tersedia di tabel."
                }
            });
        });
    </script>
@endsection
@endsection
