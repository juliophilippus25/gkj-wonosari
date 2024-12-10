@extends('landing-page.layouts.app')

@section('title', 'Katekisasi')

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
            <h1 class="mb-2 mb-lg-0">Katekisasi</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Katekisasi</li>
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
                    <h1 class="text-white">Sakramen Katekisasi</h1> <!-- Judul di sini -->
                </div>
            </div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <h2 class="text-center">Syarat & Ketentuan Katekisasi</h2>
            <p class="mt-4">Berikut adalah syarat dan ketentuan yang perlu dipenuhi untuk mengikuti program katekisasi:
            </p>
            <ul>
                <li><strong>Usia:</strong> Peserta katekisasi harus memenuhi ketentuan usia yang berlaku, baik untuk
                    anak-anak, remaja, maupun dewasa.</li>
                <li><strong>Persetujuan Orang Tua/Wali:</strong> Untuk peserta yang masih di bawah umur, persetujuan orang
                    tua atau wali yang sah sangat diperlukan.</li>
                <li><strong>Kesiapan Iman:</strong> Peserta harus menunjukkan kesiapan rohani dan mental untuk menerima
                    sakramen katekisasi, terutama bagi calon dewasa.</li>
                <li><strong>Pemilihan Nama Katekisasi:</strong> Peserta diharuskan memilih nama yang akan digunakan dalam
                    sakramen, yang mencerminkan komitmen rohani mereka.</li>
                <li><strong>Status Orang Tua/Wali:</strong> Orang tua atau wali untuk peserta yang masih anak-anak harus
                    aktif dalam kehidupan rohani gereja dan memberikan teladan iman yang baik.</li>
                <li><strong>Kelas Persiapan:</strong> Sebelum mengikuti katekisasi, peserta atau orang tua/wali diharuskan
                    mengikuti kelas persiapan sebagai bagian dari pembekalan rohani.</li>
                <li><strong>Jadwal dan Lokasi:</strong> Katekisasi akan dilakukan sesuai dengan jadwal yang telah disepakati
                    bersama dan diadakan di gereja atau lokasi yang ditentukan oleh pihak gereja.</li>
                <li><strong>Biaya Administrasi:</strong> Beberapa gereja mungkin memberlakukan biaya administrasi sebagai
                    bagian dari proses katekisasi, yang digunakan untuk keperluan liturgi dan pengelolaan acara.</li>
                <li><strong>Komitmen Iman:</strong> Setelah mengikuti katekisasi, peserta diharapkan untuk menerapkan ajaran
                    gereja dalam kehidupan sehari-hari dan hidup sesuai dengan prinsip iman Katolik.</li>
            </ul>


            @auth
                <div class="d-flex justify-content-center">
                    @if ($pernahKatekisasi)
                        <p class="text-danger">Anda sudah terdaftar untuk katekisasi.</p>
                    @else
                        <a href="{{ route('katekisasi.create') }}" class="btn"
                            style="background-color: #3498db; color: white;">Daftar Katekisasi</a>
                    @endif
                </div>
            @else
                <div class="d-flex justify-content-center">
                    <p class="text-danger">Anda harus login terlebih dahulu untuk melakukan pendaftaran katekisasi.</p>
                </div>
            @endauth
        </div>

    </section><!-- /Starter Section Section -->
@endsection
