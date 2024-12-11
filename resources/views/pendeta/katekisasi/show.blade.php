@extends('layouts.app')

@section('title', 'Pelayanan Katekisasi')

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
                            Pendaftar {{ $jadwal->layanan->nama }}
                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }},
                            {{ \Carbon\Carbon::parse($jadwal->jam)->isoFormat('H:mm a') }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jenis Katekisasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftars as $pendaftar)
                                    <tr>
                                        <td>{{ $pendaftar->profilJemaat->nama }}</td>
                                        <td>{{ $pendaftar->jenis_katekisasi }}</td>
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
                                            @if ($pendaftar->status_verifikasi == 'Diproses')
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#verificationModal{{ $pendaftar->id }}"
                                                    data-id="{{ $pendaftar->id }}">
                                                    <i class="bi bi-check"></i> Verifikasi
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $pendaftar->id }}"
                                                    data-id="{{ $pendaftar->id }}">
                                                    <i class="bi bi-eye"></i> Detail
                                                </button>
                                            @endif

                                            <!-- Verification Modal -->
                                            <div class="modal fade" id="verificationModal{{ $pendaftar->id }}"
                                                tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verificationModalLabel">Verifikasi
                                                                Pendaftar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
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
                                                                        <td>{{ $pendaftar->profilJemaat->ibu }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Akta Baptis</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            @if ($pendaftar->profilJemaat && $pendaftar->profilJemaat->akta_baptis)
                                                                                <a href="{{ asset('storage/' . $pendaftar->profilJemaat->akta_baptis) }}"
                                                                                    target="_blank"
                                                                                    class="text-decoration-none"> Lihat Akta
                                                                                    Baptis
                                                                                </a>
                                                                            @else
                                                                                <span class="text-danger">
                                                                                    Belum diupload
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#catatanModal{{ $pendaftar->id }}">
                                                                Tolak
                                                            </button>
                                                            <form
                                                                action="{{ route('katekisasi.pendeta.accept', $pendaftar->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Terima</button>
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
                                                                action="{{ route('katekisasi.pendeta.reject', $pendaftar->id) }}"
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
                                                                    <tr>
                                                                        <td class="fw-bold">Akta Baptis</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            @if ($pendaftar->profilJemaat && $pendaftar->profilJemaat->akta_baptis)
                                                                                <a href="{{ asset('storage/' . $pendaftar->profilJemaat->akta_baptis) }}"
                                                                                    target="_blank"
                                                                                    class="text-decoration-none"> Lihat
                                                                                    Akta
                                                                                    Baptis
                                                                                </a>
                                                                            @else
                                                                                <span class="text-danger">
                                                                                    Belum diupload
                                                                                </span>
                                                                            @endif
                                                                        </td>
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

            <div class="row mt-4">
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
            </div>

            <a href="{{ route('katekisasi.pendeta.index') }}" class="btn btn-secondary mt-4">Kembali</a>

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

        $(document).ready(function() {
            $('#table1').DataTable({
                searching: true, // Aktifkan pencarian
                paging: true, // Aktifkan pagination
                pageLength: 10, // Jumlah data per halaman
                language: {
                    search: "Cari", // Label pencarian
                    searchPlaceholder: "Cari {{ $dataType1 }}", // Placeholder pencarian
                    lengthMenu: "Tampilkan _MENU_ data per halaman", // Menu jumlah data per halaman
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ {{ $dataType1 }}", // Info pagination
                    infoEmpty: "Tidak ada {{ $dataType1 }}", // Pesan saat tidak ada data
                    infoFiltered: "(difilter dari _MAX_ total data)", // Pesan saat data difilter
                    zeroRecords: "Tidak ada {{ $dataType1 }} yang ditemukan.", // Pesan saat tidak ada hasil
                    emptyTable: "Tidak ada {{ $dataType1 }} di tabel."
                }
            });
        });
    </script>
@endsection
@endsection
