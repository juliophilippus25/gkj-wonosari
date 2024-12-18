@extends('layouts.app')

@section('title', 'Pendeta')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pendeta
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
                        <h3 class="card-title">Kelola Pendeta</h3>
                    </div>

                    <div class="card-body">
                        <a href="{{ route('pendeta.create') }}" class="btn btn-primary"> <i class="bi bi-plus"></i>
                            Pendeta</a>
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendetas as $pendeta)
                                    <tr>
                                        <td>{{ $pendeta->profilPendeta->nama }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#destroyModal{{ $pendeta->id }}" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>

                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="destroyModal{{ $pendeta->id }}" tabindex="-1"
                                                aria-labelledby="destroyModalLabel{{ $pendeta->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="destroyModalLabel{{ $pendeta->id }}">Konfirmasi
                                                                Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus pendeta
                                                            <strong>{{ $pendeta->profilPendeta->nama }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('pendeta.destroy', $pendeta->id) }}"
                                                                method="POST" id="destroyForm{{ $pendeta->id }}">
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
