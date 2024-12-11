@extends('landing-page.layouts.app')

@section('title', 'Sidhi/Baptis Dewasa')

@section('styles')
    <style>
        .section-title {
            position: relative;
            width: 100%;
        }

        .image-overlay {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .image-overlay img {
            width: 100%;
            height: 400px;
            display: block;
            object-fit: cover;
        }

        .image-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            /* Warna gelap dengan transparansi */
            z-index: 1;
        }

        .title-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            z-index: 100;
            text-align: center;
        }

        .title-overlay h1 {
            font-size: 2rem;
            /* Ukuran font bisa disesuaikan */
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Sidhi/Baptis Dewasa</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Sidhi/Baptis Dewasa</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section id="starter-section" class="starter-section section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <div class="image-overlay">
                <img src="{{ asset('imgs/gedung.jpg') }}" alt="GKJ Wonosari">
                <div class="title-overlay">
                    <h1 class="text-white">Sakramen Sidhi/Baptis Dewasa</h1> <!-- Judul di sini -->
                </div>
            </div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <h2 class="text-center">Syarat & Ketentuan Sidhi/Baptis Dewasa</h2>
            <p class="mt-4">Berikut adalah syarat dan ketentuan yang perlu dipenuhi untuk mengikuti sakramen Sidhi/Baptis
                Dewasa:</p>
            <ul>
                <li><strong>Usia:</strong> Peserta Sidhi/Baptis Dewasa harus berusia sesuai dengan ketentuan gereja, yaitu
                    dewasa secara usia dan mental untuk memahami makna sakramen ini.</li>
                <li><strong>Kesiapan Iman:</strong> Peserta diharapkan memiliki kesiapan rohani dan pemahaman yang mendalam
                    tentang ajaran iman Katolik, serta komitmen untuk hidup sesuai dengan ajaran tersebut.</li>
                <li><strong>Pemilihan Nama Baptis:</strong> Calon peserta harus memilih nama baptis yang akan digunakan
                    dalam sakramen sebagai simbol komitmen dalam iman.</li>
                <li><strong>Persetujuan Orang Tua/Wali:</strong> Bagi peserta yang membutuhkan, persetujuan orang tua atau
                    wali mungkin diperlukan, terutama untuk mereka yang berusia lebih muda namun memenuhi syarat untuk
                    Sidhi/Baptis Dewasa.</li>
                <li><strong>Ikut Kelas Persiapan Baptis:</strong> Sebelum pelaksanaan Sidhi/Baptis Dewasa, calon peserta
                    diharuskan mengikuti kelas persiapan sebagai bekal rohani untuk memahami makna dan tanggung jawab
                    sakramen ini.</li>
                <li><strong>Jadwal dan Tempat:</strong> Sidhi/Baptis Dewasa biasanya dilaksanakan di gereja atau tempat yang
                    telah disetujui, mengikuti jadwal yang telah disepakati dengan gereja setempat.</li>
                <li><strong>Biaya Administrasi:</strong> Beberapa gereja mungkin menetapkan biaya administrasi untuk
                    keperluan liturgi, pengelolaan acara, dan administrasi lainnya terkait dengan Sidhi/Baptis Dewasa.</li>
                <li><strong>Komitmen untuk Hidup dalam Iman:</strong> Setelah Sidhi/Baptis Dewasa, peserta diharapkan untuk
                    terus menghidupi iman Katolik mereka, berpartisipasi dalam kehidupan gereja, dan mengikuti ajaran serta
                    sakramen gereja secara aktif.</li>
            </ul>

            @auth
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        @if ($pernahSidhi && !$sidhiTidakHadir)
                            <p class="text-danger">Anda sudah terdaftar untuk sidhi/baptis dewasa.</p>
                        @elseif ($sidhiTidakHadir)
                            <a href="{{ route('sidhi.create') }}" class="btn"
                                style="background-color: #3498db; color: white;">Daftar sidhi/baptis dewasa</a>
                        @else
                            <a href="{{ route('sidhi.create') }}" class="btn"
                                style="background-color: #3498db; color: white;">Daftar sidhi/baptis dewasa</a>
                        @endif
                    </div>
                </div>
            @else
                <div class="d-flex justify-content-center">
                    <p class="text-danger">Anda harus login terlebih dahulu untuk melakukan pendaftaran sidhi/baptis dewasa.</p>
                </div>
            @endauth
        </div>

    </section><!-- /Starter Section Section -->
@endsection
