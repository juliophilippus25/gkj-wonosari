@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pengguna
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
                        <h3 class="card-title">Kelola Pengguna</h3>
                    </div>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td class="text-capitalize">{{ $user->role }}</td>
                                        <td>
                                            @if ($user->isVerified == 0)
                                                <span class="badge bg-danger">Belum Diverifikasi</span>
                                            @elseif ($user->isVerified == 1)
                                                <span class="badge bg-success">Terverifikasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->isVerified == 0)
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#verifyModal{{ $user->id }}" title="Verifikasi">
                                                    <i class="bi bi-check"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="verifyModal{{ $user->id }}" tabindex="-1"
                                                    aria-labelledby="verifyModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="verifyModalLabel{{ $user->id }}">Konfirmasi
                                                                    Verifikasi</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin memverifikasi pengguna
                                                                {{ $user->name }}?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form action="{{ route('users.verify', $user->id) }}"
                                                                    method="POST" id="verifyForm{{ $user->id }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Verifikasi</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($user->isVerified == 1)
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $user->id }}" title="Detail">
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
    @endsection
