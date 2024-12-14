@extends('landing-page.layouts.app')

@section('title', 'Baptis')

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
            <h1 class="mb-2 mb-lg-0">Baptis</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Baptis</li>
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
                    <h1 class="text-white">Sakramen Baptis</h1> <!-- Judul di sini -->
                </div>
            </div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <h2 class="text-center">Syarat & Ketentuan Baptis</h2>
            <p class="mt-4">Berikut adalah syarat dan ketentuan yang perlu dipenuhi untuk mengikuti sakramen baptis:</p>
            <ul>
                <li><strong>Usia:</strong> Peserta baptis harus berusia sesuai dengan ketentuan gereja (misalnya, bayi,
                    anak-anak, atau orang dewasa).</li>
                <li><strong>Persetujuan Orang Tua atau Wali:</strong> Untuk bayi atau anak-anak, persetujuan dari orang tua
                    atau wali diperlukan.</li>
                <li><strong>Kesiapan Rohani:</strong> Calon baptisan harus memiliki kesiapan rohani untuk menerima sakramen
                    ini (khususnya bagi orang dewasa yang akan dibaptis).</li>
                <li><strong>Memiliki Nama Baptis:</strong> Calon baptisan harus memilih nama baptis yang akan digunakan
                    dalam sakramen ini.</li>
                <li><strong>Calon Orang Tua Baptis (Wali):</strong> Bagi bayi atau anak, orang tua baptis atau wali yang
                    akan menjamin kehidupan rohani calon baptisan harus memiliki status sebagai umat Katolik yang aktif dan
                    setia.</li>
                <li><strong>Ikut Kelas Persiapan Baptis:</strong> Sebelum pelaksanaan baptis, calon peserta (atau orang tua
                    dan wali) diharuskan mengikuti kelas persiapan baptis.</li>
                <li><strong>Jadwal dan Tempat:</strong> Baptisan biasanya dilakukan di gereja atau tempat yang ditentukan
                    sesuai dengan jadwal yang telah disetujui dengan gereja setempat.</li>
                <li><strong>Biaya Administrasi:</strong> Beberapa gereja mungkin meminta biaya administrasi sebagai bagian
                    dari proses baptisan, yang digunakan untuk biaya liturgi dan administrasi.</li>
                <li><strong>Keinginan untuk Hidup dalam Iman:</strong> Setelah baptisan, peserta diharapkan hidup dalam iman
                    Katolik dan mengikuti ajaran gereja.</li>
            </ul>

            @auth
                @if (Auth::user()->role === 'jemaat')
                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-center">
                            @if ($pernahBaptis && !$baptisTidakHadir)
                                <p class="text-danger">Anda sudah terdaftar untuk baptis.</p>
                            @elseif ($baptisTidakHadir)
                                <a href="{{ route('baptis.create') }}" class="btn"
                                    style="background-color: #3498db; color: white;">Daftar Baptis</a>
                            @else
                                <a href="{{ route('baptis.create') }}" class="btn"
                                    style="background-color: #3498db; color: white;">Daftar Baptis</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        <p class="text-danger">Anda harus login terlebih dahulu untuk melakukan pendaftaran baptis.</p>
                    </div>
                @endif
            @endauth

        </div>

    </section><!-- /Starter Section Section -->
@endsection
