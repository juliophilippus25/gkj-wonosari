@extends('landing-page.layouts.app')

@section('title', 'Jadwal Pelayanan')

@section('styles')
    <style>
        .filter-btn {
            border: 2px solid #3498db;
            background-color: white;
            color: #3498db;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background-color: #3498db;
            color: white;
            border: 2px solid #3498db;
        }

        .filter-btn:hover {
            background-color: #c9e9ff;
            color: #3498db;
            border: 2px solid #3498db;
        }
    </style>
@endsection

@section('content')

    <section id="starter-section" class="services section">
        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Jadwal Pelayanan</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="current">Jadwal Pelayanan</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <div class="container" data-aos="fade-up">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Jadwal Pelayanan</h2>
                <p>Temukan jadwal pelayanan yang sesuai dengan kebutuhan Anda.</p>
                <div class="mt-4">
                    <div class="d-flex justify-content-center gap-2" role="group" aria-label="Filter Jadwal Pelayanan">
                        <button type="button" class="filter-btn active" id="filter-all">Tampilkan Semua</button>
                        <button type="button" class="filter-btn" id="filter-baptis-dewasa">Baptis</button>
                        <button type="button" class="filter-btn" id="filter-sidhi">Sidhi/Baptis Dewasa</button>
                        <button type="button" class="filter-btn" id="filter-katekisasi">Katekisasi</button>
                    </div>
                </div>
            </div><!-- End Section Title -->

            <div class="row gy-4">
                @forelse ($jadwals as $jadwal)
                    @if (!$jadwal->isExpired)
                        <div class="col-lg-4 col-md-6 jadwal {{ strtolower(str_replace(['/', ' '], [' ', '_'], $jadwal->layanan->nama)) }}"
                            data-aos="fade-up" data-aos-delay="100">
                            <div class="service-item  position-relative">
                                <a href="{{ route('lp.jadwal.show', $jadwal->id) }}" class="stretched-link">
                                    <h3>Pelayanan {{ $jadwal->layanan->nama }}</h3>
                                </a>
                                <div class="d-flex flex-column gap-1">
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-bold">Tanggal</p>
                                        <p>{{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-bold">Jam</p>
                                        <p>{{ \Carbon\Carbon::parse($jadwal->jam)->isoFormat('H:mm a') }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-bold">Pendeta</p>
                                        <p>{{ $jadwal->pendeta->profilPendeta->nama }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-bold">Jumlah Pendaftar</p>
                                        <p>{{ $jadwal->jumlah_pendaftar }}</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Service Item -->
                    @endif
                @empty
                    <p class="text-center text-danger">Belum ada jadwal pelayanan.</p>
                @endforelse
            </div>
        </div>

    </section><!-- /Starter Section Section -->

    <script>
        document.getElementById('filter-baptis-dewasa').addEventListener('click', function() {
            setActiveButton('filter-baptis-dewasa');
            filterJadwal('baptis');
        });

        document.getElementById('filter-sidhi').addEventListener('click', function() {
            setActiveButton('filter-sidhi');
            filterJadwal('sidhi_baptis_dewasa');
        });

        document.getElementById('filter-katekisasi').addEventListener('click', function() {
            setActiveButton('filter-katekisasi');
            filterJadwal('katekisasi');
        });

        document.getElementById('filter-all').addEventListener('click', function() {
            setActiveButton('filter-all');
            showAllJadwal();
        });

        function setActiveButton(activeId) {
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(button => {
                button.classList.remove('active');
            });

            document.getElementById(activeId).classList.add('active');
        }

        function filterJadwal(kategori) {
            const semuaJadwal = document.querySelectorAll('.jadwal');

            semuaJadwal.forEach(function(jadwal) {
                if (jadwal.classList.contains(kategori)) {
                    jadwal.style.display = 'block';
                } else {
                    jadwal.style.display = 'none';
                }
            });
        }

        function showAllJadwal() {
            const semuaJadwal = document.querySelectorAll('.jadwal');
            semuaJadwal.forEach(function(jadwal) {
                jadwal.style.display = 'block';
            });
        }
    </script>
@endsection
