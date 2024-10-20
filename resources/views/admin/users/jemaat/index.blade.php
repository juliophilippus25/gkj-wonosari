@extends('layouts.app')

@section('title', 'Jemaat')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Jemaat
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
                        <h3 class="card-title">Kelola Jemaat</h3>
                    </div>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jemaats as $jemaat)
                                    <tr>
                                        <td>{{ $jemaat->name }}</td>
                                        <td>
                                            @if ($jemaat->is_verified == 0)
                                                <span class="badge bg-danger">Belum Diverifikasi</span>
                                            @elseif ($jemaat->is_verified == 1)
                                                <span class="badge bg-success">Terverifikasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($jemaat->is_verified == 0)
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#verifyModal{{ $jemaat->id }}" title="Verifikasi">
                                                    <i class="bi bi-check"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="verifyModal{{ $jemaat->id }}" tabindex="-1"
                                                    aria-labelledby="verifyModalLabel{{ $jemaat->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="verifyModalLabel{{ $jemaat->id }}">Konfirmasi
                                                                    Verifikasi</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin memverifikasi jemaat
                                                                {{ $jemaat->name }}?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('jemaat.verify', $jemaat->id) }}"
                                                                    method="POST" id="verifyForm{{ $jemaat->id }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Verifikasi</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($jemaat->is_verified == 1)
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $jemaat->id }}" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /.row -->
            </div> <!--end::Container-->
        </div> <!--end::App Content-->
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
