<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GKJ Wonosari | Surat {{ $pendaftar->jadwal->layanan->nama }}</title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .upper {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td><img src="{{ public_path('imgs/logo.png') }}" alt="" style="width: 100px; height: 100px;">
            </td>
            <td class="center">
                <font size="5" style="font-weight: bold;">GEREJA KRISTEN JAWA (GKJ) <br> WONOSARI</font> <br>
                <font size="2">
                    <i>
                        Jl. Gereja No.11-12, Purbosari, Kec. Wonosari, Kabupaten
                        Gunung Kidul, Daerah
                        Istimewa Yogyakarta 55812. <br>
                        No. Telepon: +62 822-4242-1241, Email: gkjwonosari@gmail.com
                    </i>
                </font>
            </td>
        </tr>
    </table>

    <hr width="100%" align="center">

    <h2 style="margin-bottom: 24px; margin-top: 32px">
        <center class="upper">SURAT {{ $pendaftar->jadwal->layanan->nama }}</center>
    </h2>

    <div
        style="font-family: Arial, sans-serif; line-height: 1.8; width: 100%; max-width: 600px; margin: 0 auto; text-align: left;">
        <p style="text-align: justify;"><strong>MAJELIS JEMAAT GKJ WONOSARI</strong> menerangkan dengan sesungguhnya
            bahwa pada hari
            <strong
                class="upper">{{ \Carbon\Carbon::parse($pendaftar->jadwal->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</strong>
            dalam
            kebaktian jemaat <strong>GKJ
                WONOSARI</strong> telah dilaksanakan <strong
                class="upper">{{ $pendaftar->jadwal->layanan->nama }}</strong>, dalam nama Allah Bapa, Anak dan Roh
            Kudus atas dari :
        </p>

        <div style="margin-top: 16px; text-transform: uppercase;">
            <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Nama Lengkap</span>:
                <strong>{{ $pendaftar->profilJemaat->nama }}</strong>
            </p>
            <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Tempat dan Tanggal
                    Lahir</span>: {{ $pendaftar->profilJemaat->tempat_lahir }},
                {{ \Carbon\Carbon::parse($pendaftar->profilJemaat->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</p>
            <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Nama Lengkap Ayah</span
                    class="upper">:
                {{ $pendaftar->profilJemaat->ayah }}</p>
            <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Nama Lengkap Ibu</span>:
                {{ $pendaftar->profilJemaat->ibu }}</p>
        </div>

        <div style="margin-top: 12px; text-align: center;">
            <p>Pelayanan {{ $pendaftar->jadwal->layanan->nama }} tersebut dilayani oleh :</p>
            <p><strong>{{ $pendaftar->jadwal->pendeta->profilPendeta->nama }}</strong></p>
        </div>
    </div>

</body>

</html>
