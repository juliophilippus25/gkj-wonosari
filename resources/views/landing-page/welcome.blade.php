@extends('landing-page.layouts.app')

@section('title', 'Home')

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
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <img src="{{ asset('imgs/gedung.jpg') }}" alt="GKJ Wonosari" data-aos="fade-in">

        <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                @auth
                    <div class="col-lg-8">
                        <p>Selamat datang,</p>
                        <h2>
                            @if (auth()->user()->role == 'admin')
                                {{ auth()->user()->profilAdmin->nama }}
                            @elseif(auth()->user()->role == 'jemaat')
                                {{ auth()->user()->profilJemaat->nama }}
                            @elseif(auth()->user()->role == 'pendeta')
                                {{ auth()->user()->profilPendeta->nama }}
                            @endif
                        </h2>
                    </div>
                @else
                    <div class="col-lg-8">
                        <h2>Website Pelayanan</h2>
                        <p>Baptis, Sidhi/Baptis Dewasa, dan Katekisasi {{ config('app.name') }}</p>
                        <a href="{{ route('login') }}" class="btn-get-started">Login</a>
                    </div>
                @endauth
            </div>
        </div>

    </section>

    <!-- Layanan Kami -->
    <section class="what-we-do section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Layanan Kami</h2>
            <p>Temukan berbagai layanan yang kami tawarkan sesuai dengan kebutuhan Anda.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-xl-4">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <h4>Baptis</h4>
                                <p>Pelayanan Baptis adalah sakramen penting dalam kehidupan Kristen, yang menandakan awal
                                    kehidupan rohani seseorang. Kami menyambut Anda untuk merayakan momen berharga ini
                                    bersama keluarga dan komunitas kami. Ikuti proses dengan panduan yang penuh kasih dan
                                    pengertian.</p>
                                <a href="{{ route('baptis') }}" class="stretched-link">Lihat Selengkapnya</a>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <h4>Sidhi/Baptis Dewasa</h4>
                                <p>Layanan Sidhi atau Baptis Dewasa adalah kesempatan untuk memperbarui iman dalam usia
                                    dewasa, memberikan pemahaman lebih mendalam tentang ajaran Kristen. Ini adalah sakramen
                                    penting yang menandai komitmen seseorang terhadap kehidupan rohani yang lebih penuh.</p>
                                <a href="{{ route('sidhi') }}" class="stretched-link">Lihat Selengkapnya</a>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <h4>Katekisasi</h4>
                                <p>Katekisasi adalah program pendidikan agama untuk memperkenalkan ajaran Kristen lebih
                                    dalam. Layanan ini dirancang untuk membantu individu mempelajari dasar-dasar iman dan
                                    memperkuat hubungan dengan Tuhan. Ikuti kelas katekisasi kami untuk membangun landasan
                                    rohani yang kuat.
                                </p>
                                <a href="{{ route('katekisasi') }}" class="stretched-link">Lihat Selengkapnya</a>
                            </div>
                        </div><!-- End Icon Box -->

                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- Jadwal Pelayanan -->
    <section class="services section light-background">

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

        <div class="container" data-aos="fade-up">

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
                                        <p class="fw-bold">Jenis Bahasa</p>
                                        <p>{{ $jadwal->jenis_bahasa }}</p>
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

    </section>

    <!-- Kontak -->
    <section class="contact section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Kontak Kami</h2>
            <p>Apakah Anda memiliki pertanyaan atau butuh informasi lebih lanjut? Kami siap membantu Anda! Jangan ragu untuk
                menghubungi kami melalui berbagai saluran yang tersedia. Kami akan dengan senang hati memberikan respons
                cepat dan solusi terbaik untuk kebutuhan Anda.</p>
        </div><!-- End Section Title -->

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-7">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.3276885888476!2d110.60003647484626!3d-7.965047192059762!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7bb3439f69798d%3A0x603fe0f76df26f1e!2sGKJ%20Wonosari!5e0!3m2!1sid!2sid!4v1732431368685!5m2!1sid!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div><!-- End Contact Form -->

                <div class="col-lg-5">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Alamat</h3>
                            <p>Jl. Gereja No.11-12, Purbosari, Kec. Wonosari, Kabupaten Gunung Kidul, Daerah Istimewa
                                Yogyakarta 55812.</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Hubungi Kami</h3>
                            <p>+62 822-4242-1241</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Kami</h3>
                            <p>gkjwonosari@gmail.com</p>
                        </div>
                    </div><!-- End Info Item -->

                </div>

            </div>

        </div>

    </section>

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
