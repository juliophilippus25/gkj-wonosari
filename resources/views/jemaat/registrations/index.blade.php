@extends('layouts.app')

@section('title', 'Pendaftaran')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pendaftaran
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
                        <h3 class="card-title">Pendaftaran</h3>
                    </div>

                    <div class="card-body">
                        <a href="{{ route('registrations.create') }}" class="btn btn-primary"> <i class="bi bi-plus"></i>
                            Daftar</a>
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Waktu Pelaksanaan</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($registration->schedule->date)->isoFormat('dddd, D MMMM YYYY') }},
                                            {{ \Carbon\Carbon::parse($registration->schedule->time)->format('H:i') }}</td>
                                        <td>
                                            {{ $registration->schedule->services->name }}
                                            oleh
                                            {{ $registration->schedule->users->name }}
                                        </td>
                                        <td>
                                            @if ($registration->status == 'pending')
                                                <span class="badge bg-warning">Diproses</span>
                                            @elseif ($registration->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif ($registration->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">Status Tidak Diketahui</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($registration->status == 'approved' && $registration->schedule->services->name == 'Katekisasi')
                                                <a target="_blank" href="#" class="btn btn-success btn-sm"><i
                                                        class="bi bi-download"></i></a>
                                            @endif
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
