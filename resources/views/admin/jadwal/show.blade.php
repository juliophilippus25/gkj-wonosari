@extends('layouts.app')

@section('title', 'Pendaftar')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pelayanan {{ $jadwal->layanan->nama }}
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
                        <h3 class="card-title">
                            Pendaftar Pelayanan {{ $jadwal->layanan->nama }}
                        </h3>
                    </div>

                    <div class="card-body">
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
                                    <td style="width: 10%;" class="fw-bold">Jumlah Pendaftar</td>
                                    <td style="width: 0%;">:</td>
                                    <td>
                                        {{ $jadwal->jumlah_pendaftar }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Kehadiran</th>
                                    <th>Aksi</th>
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
                                        <td>
                                            @if ($pendaftar->status_kehadiran == 'Belum')
                                                <span class="badge bg-warning">Belum Dimulai</span>
                                            @elseif ($pendaftar->status_kehadiran == 'Hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif ($pendaftar->status_kehadiran == 'Tidak Hadir')
                                                <span class="badge bg-danger">Tidak Hadir</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pendaftar->status_kehadiran == 'Belum')
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#verificationModal{{ $pendaftar->id }}"
                                                    data-id="{{ $pendaftar->id }}">
                                                    <i class="bi bi-check"></i> Verifikasi
                                                </button>
                                            @elseif($pendaftar->status_kehadiran == 'Hadir')
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $pendaftar->id }}"
                                                    data-id="{{ $pendaftar->id }}">
                                                    <i class="bi bi-download"></i> Unduh {{ $jadwal->layanan->nama }}
                                                </button>
                                            @endif

                                            <!-- Verification Modal -->
                                            <div class="modal fade" id="verificationModal{{ $pendaftar->id }}"
                                                tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verificationModalLabel">Verifikasi
                                                                Kehadiran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Pastikan bahwa Anda memverifikasi dengan benar kehadiran
                                                            <strong>{{ $pendaftar->profilJemaat->nama }}</strong> sebelum
                                                            menekan tombol konfirmasi.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('jadwal.absent', $pendaftar->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">Tidak
                                                                    Hadir</button>
                                                            </form>
                                                            <form action="{{ route('jadwal.present', $pendaftar->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Hadir</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Catatan untuk Tolak -->
                                            <div class="modal fade" id="catatanModal{{ $pendaftar->id }}" tabindex="-1"
                                                aria-labelledby="catatanModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="catatanModalLabel">
                                                                Tolak Pendaftar {{ $pendaftar->profilJemaat->nama }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Catatan Tolak -->
                                                            <form
                                                                action="{{ route('baptis.pendeta.reject', $pendaftar->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="catatan"
                                                                        class="form-label">Catatan:</label>
                                                                    <textarea class="form-control" id="catatan" name="catatan" rows="3" required></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger">Tolak
                                                                        Pendaftar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detail Modal -->
                                            <div class="modal fade" id="detailModal{{ $pendaftar->id }}" tabindex="-1"
                                                aria-labelledby="verificationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verificationModalLabel">Detail
                                                                Pendaftar</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Data Penanggung Jawab -->
                                                            <table class="table-borderless w-100 mb-4">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="fw-bold" style="width: 45%">Nama
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td style="width: 55%">
                                                                            {{ $pendaftar->profilJemaat->nama }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Jenis kelamin</td>
                                                                        <td>:</td>
                                                                        <td>{{ $pendaftar->profilJemaat->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Tempat dan tanggal lahir</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $pendaftar->profilJemaat->tempat_lahir }},
                                                                            {{ \Carbon\Carbon::parse($pendaftar->profilJemaat->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Wilayah</td>
                                                                        <td>:</td>
                                                                        <td>{{ $pendaftar->profilJemaat->wilayah->nama }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Nama ayah</td>
                                                                        <td>:</td>
                                                                        <td>{{ $pendaftar->profilJemaat->ayah }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Nama ibu</td>
                                                                        <td>:</td>
                                                                        <td>{{ $pendaftar->profilJemaat->ibu }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div> <!-- /.row -->

            {{-- <div class="row mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Pendaftar ditolak
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftarDitolaks as $pendaftar)
                                    <tr>
                                        <td>{{ $pendaftar->profilJemaat->nama }}</td>
                                        <td>
                                            {{ $pendaftar->catatan ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}

            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary mt-4">Kembali</a>

        </div> <!--end::Container-->
    </div> <!--end::App Content-->

@section('script')
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
