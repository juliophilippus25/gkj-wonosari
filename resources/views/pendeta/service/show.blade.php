@extends('layouts.app')

@section('title', 'Pelayanan')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pelayanan
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
                        <h3 class="card-title">Pendaftar <span class="text-lowercase">{{ $schedule->services->name }}</span>
                            {{ \Carbon\Carbon::parse($schedule->date)->isoFormat('D MMMM YYYY') }}
                        </h3>
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
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->name }}</td>
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
                                            @if ($registration->status == 'pending')
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#verificationModal{{ $registration->id }}"
                                                    data-id="{{ $registration->id }}">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $registration->id }}"
                                                    data-id="{{ $registration->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            @endif

                                            <!-- Verification Modal -->
                                            <div class="modal fade" id="verificationModal{{ $registration->id }}"
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
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="3" class="text-center fw-bold fs-4">
                                                                            Data Pendaftar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="fw-bold" style="width: 45%">Nama
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td style="width: 55%">{{ $registration->name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Jenis kelamin</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->gender === 'M' ? 'Laki-laki' : 'Perempuan' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Tempat dan tanggal lahir</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $registration->place_of_birth }},
                                                                            {{ \Carbon\Carbon::parse($registration->date_of_birth)->isoFormat('D MMMM YYYY') }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Alamat</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->address }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Wilayah</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->region->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Nama orang tua</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->user->name }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('service.rejectRegistrant', $registration->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                                            </form>
                                                            <form
                                                                action="{{ route('service.acceptRegistrant', $registration->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-primary">Terima</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detail Modal -->
                                            <div class="modal fade" id="detailModal{{ $registration->id }}" tabindex="-1"
                                                aria-labelledby="verificationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="verificationModalLabel">Detail
                                                                Pendaftar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Data Penanggung Jawab -->
                                                            <table class="table-borderless w-100 mb-4">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="3" class="text-center fw-bold fs-4">
                                                                            Data Pendaftar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="fw-bold" style="width: 45%">Nama
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td style="width: 55%">{{ $registration->name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Jenis kelamin</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->gender === 'M' ? 'Laki-laki' : 'Perempuan' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Tempat dan tanggal lahir</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $registration->place_of_birth }},
                                                                            {{ \Carbon\Carbon::parse($registration->date_of_birth)->isoFormat('D MMMM YYYY') }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Alamat</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->address }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Wilayah</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->region->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="fw-bold">Nama orang tua</td>
                                                                        <td>:</td>
                                                                        <td>{{ $registration->user->name }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
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

                    <div class="card-footer">
                        <a href="{{ route('service.index') }}" class="btn btn-secondary">Kembali</a>
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
