<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GKJ Wonosari | Surat Kehadiran Katekisasi</title>
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

        .container {
            width: 100%;
            margin-top: 30px;
        }

        /* Style for the big box container */
        /* .box {
            border: 2px solid #000;
            padding: 20px;
            margin-bottom: 20px;
        } */

        /* Table Style */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table Cells Style */
        .table td {
            padding: 10px;
            border: 1px solid;
            vertical-align: top;
            height: 140px;
            /* Set height for each row */
        }

        /* Label styles for the headers (Tanggal and Catatan) */
        .table .header {
            font-weight: bold;
            text-align: center;
        }

        .table .date-column {
            width: 50%;
        }

        .table .note-column {
            width: 50%;
        }

        /* .table td.empty {
            background-color: #f9f9f9;
        } */

        /* Label style for each row */
        .label {
            font-weight: bold;
        }

        .signature {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 20px auto;
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
        <center class="upper">KARTU KEHADIRAN KATEKISASI</center>
    </h2>

    <div>
        <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Nama Lengkap</span>:
            <strong>{{ $profilJemaat->nama }}</strong>
        </p>
        <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Tempat dan Tanggal Lahir</span>:
            {{ $profilJemaat->tempat_lahir }},
            {{ \Carbon\Carbon::parse($profilJemaat->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</p>
        <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Jenis Katekisasi</span>:
            {{ $katekisasi->jenis_katekisasi }}</p>
        <p style="margin: 4px 0;"><span style="display: inline-block; width: 250px;">Pendeta</span>:
            {{ $katekisasi->jadwal->pendeta->profilPendeta->nama }}
        </p>
    </div>

    <!-- Kotak Tanggal dan Catatan -->
    <div class="container">
        <div class="box">
            <table class="table">
                <tbody>
                    @for ($i = 1; $i <= 9; $i++)
                        <tr>
                            <td class="empty">
                                <span class="label">Tanggal:</span> ____________________________
                            </td>
                            <td class="empty">
                                <span class="label">Tanggal:</span> ____________________________
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    {{-- TTD Pendeta --}}
    <div class="signature">
        <p class="bold">Pendeta</p>

        <p style="margin-top: 100px;"> {{ $katekisasi->jadwal->pendeta->profilPendeta->nama }}</p>
    </div>
</body>

</html>
