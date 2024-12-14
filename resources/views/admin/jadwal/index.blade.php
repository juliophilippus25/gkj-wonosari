@extends('layouts.app')

@section('title', 'Jadwal')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Jadwal
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
                        <h3 class="card-title">Kelola Jadwal</h3>
                    </div>

                    <div class="card-body">
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary"> <i class="bi bi-plus"></i>
                            Jadwal</a>
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Waktu Pelaksanaan</th>
                                    <th>Pelayanan</th>
                                    <th>Pendeta</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }} -
                                            {{ \Carbon\Carbon::parse($jadwal->jam)->isoFormat('H:mm a') }}</td>
                                        <td>{{ $jadwal->layanan->nama }}</td>
                                        <td>{{ $jadwal->pendeta->profilPendeta->nama }}</td>
                                        <td>
                                            <span
                                                class="{{ $jadwal->isExpired ? 'badge bg-success' : 'badge bg-warning' }}">
                                                {{ $jadwal->isExpired ? 'Sudah Dilaksanakan' : 'Belum Dilaksanakan' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal.show', $jadwal->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#destroyModal{{ $jadwal->id }}" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>

                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="destroyModal{{ $jadwal->id }}" tabindex="-1"
                                                aria-labelledby="destroyModalLabel{{ $jadwal->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="destroyModalLabel{{ $jadwal->id }}">Konfirmasi
                                                                Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus jadwal pelayanan
                                                            <strong>{{ $jadwal->layanan->nama }}</strong> di
                                                            <strong>
                                                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($jadwal->jam)->isoFormat('H:mm a') }}
                                                            </strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}"
                                                                method="POST" id="destroyForm{{ $jadwal->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
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
