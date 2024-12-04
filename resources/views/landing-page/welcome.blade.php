@extends('landing-page.layouts.app')

@section('title', 'Home')

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

    <!-- Jadwal Pelayanan -->
    <section id="jadwal-pelayanan" class="what-we-do section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Layanan Kami</h2>
            <p>Temukan berbagai layanan yang kami tawarkan sesuai dengan kebutuhan Anda. Kami menyediakan jadwal yang
                fleksibel dan dapat disesuaikan, sehingga Anda dapat memilih waktu yang paling nyaman dan sesuai dengan
                jadwal Anda.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-xl-4">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Baptis</h4>
                                <p>Pelayanan Baptis adalah sakramen penting dalam kehidupan Kristen, yang menandakan awal
                                    kehidupan rohani seseorang. Kami menyambut Anda untuk merayakan momen berharga ini
                                    bersama keluarga dan komunitas kami. Ikuti proses dengan panduan yang penuh kasih dan
                                    pengertian.</p>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-gem"></i>
                                <h4>Sidhi/Baptis Dewasa</h4>
                                <p>Layanan Sidhi atau Baptis Dewasa adalah kesempatan untuk memperbarui iman dalam usia
                                    dewasa, memberikan pemahaman lebih mendalam tentang ajaran Kristen. Ini adalah sakramen
                                    penting yang menandai komitmen seseorang terhadap kehidupan rohani yang lebih penuh.</p>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-inboxes"></i>
                                <h4>Katekisasi</h4>
                                <p>Katekisasi adalah program pendidikan agama untuk memperkenalkan ajaran Kristen lebih
                                    dalam. Layanan ini dirancang untuk membantu individu mempelajari dasar-dasar iman dan
                                    memperkuat hubungan dengan Tuhan. Ikuti kelas katekisasi kami untuk membangun landasan
                                    rohani yang kuat.
                                </p>
                            </div>
                        </div><!-- End Icon Box -->

                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- Pengumuman -->
    <section id="pengumuman" class="services section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Pengumuman</h2>
            <p>Berikut adalah informasi terkini yang perlu Anda ketahui. Kami akan membagikan pengumuman penting terkait
                kegiatan, acara, atau pembaruan lainnya. Pastikan Anda tidak ketinggalan informasi terbaru yang kami
                sampaikan di sini.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item  position-relative">
                        <div class="icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Nesciunt Mete</h3>
                        </a>
                        <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores
                            iure perferendis tempore et consequatur.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Eosle Commodi</h3>
                        </a>
                        <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque eum
                            hic non ut nesciunt dolorem.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-easel"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Ledo Markt</h3>
                        </a>
                        <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id
                            voluptas adipisci eos earum corrupti.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-bounding-box-circles"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Asperiores Commodit</h3>
                        </a>
                        <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed error ea fuga
                            sit provident adipisci neque.</p>
                        <a href="service-details.html" class="stretched-link"></a>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Velit Doloremque</h3>
                        </a>
                        <p>Cumque et suscipit saepe. Est maiores autem enim facilis ut aut ipsam corporis aut. Sed
                            animi at autem alias eius labore.</p>
                        <a href="service-details.html" class="stretched-link"></a>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-chat-square-text"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Dolori Architecto</h3>
                        </a>
                        <p>Hic molestias ea quibusdam eos. Fugiat enim doloremque aut neque non et debitis iure.
                            Corrupti recusandae ducimus enim.</p>
                        <a href="service-details.html" class="stretched-link"></a>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>

    </section>

    <!-- Kontak -->
    <section id="kontak" class="contact section">

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
@endsection
