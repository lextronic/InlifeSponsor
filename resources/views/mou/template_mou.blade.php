<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoU Kerjasama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1;
            margin-top: 0;
            margin-bottom: 60px;
            margin-left: 60px;
            margin-right: 0;
        }

        .container {
            max-width: 800px;
        }

        .section {
            margin-bottom: 10px;
            text-align: justify;
        }

        .text-center {
            text-align: center;
        }

        .section p {
            margin: 0;
            padding: 0;
        }

        p {
            font-size: 14px;
        }

        h2 {
            text-align: left;
            font-size: 14px;
            font-weight: normal;
        }

        h1 {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-top: -10px;
            margin-left: 40px;
            margin-right: 30px;
            line-height: 1.5;
        }

        .section .contact-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1px;
            margin-left: 43px;
        }

        .contact-info ol {
            list-style-type: none;
            padding-left: 0;
            font-size: 14px;
        }

        .contact-info li {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .contact-info ol li {
            display: flex;
            align-items: baseline;
            margin-bottom: 5px;
        }

        .contact-info ol li span {
            width: 100px;
            /* Atur lebar sesuai dengan panjang label */
            display: inline-block;
        }
    </style>
</head>

<body>

    <img src="{{ public_path('image/logo-telkomsel-baru.png') }}" alt="Logo Telkomsel" style="float: right; margin-top:0;">
    <div style="clear: both;"></div>

    <h1 class="text-center" style="text-align:center;">
        BERITA ACARA KESEPAKATAN
    </h1>
    <h1 class="text-center" style="margin-bottom:50px; text-align:center;">
        PROGRAM SPONSORSHIP TELKOMSEL SURABAYA
    </h1>
    <div class="section">
        <p>Kami yang bertanda tangan di bawah ini,</p>

        <div class="contact-info">
            <ol>
                <li><span>Nama</span>: {{$pr_name}}</li>
                <li><span>Jabatan</span>: Staff Mobile Consumer Operation Territory Kota Surabaya</li>
                <li><span>Alamat</span>: Telkom Landmark Tower, Jl. Ir. H. Soekarno No 175 Surabaya</li>
            </ol>
        </div>
        <p>Selanjutnya disebut sebagai <strong>Pihak Pertama</strong>, mewakili <strong>PT. Telkomsel</strong></p>

        <div class="contact-info">
            <ol>
                <li><span>Nama</span>: {{$pic_name}}</li>
                <li><span>Instansi</span>: {{$organizer_name}}</li>
                <li><span>No Telepon</span>: {{$phone_number}}</li>
            </ol>
        </div>
        <p>Selanjutnya disebut sebagai <strong>Pihak Kedua</strong>, sebagai pihak Instansi.</p>
    </div>
    <div class="section" style="margin-bottom: 0;">
        <p style="margin-top:10px;">Kedua belah pihak telah sepakat untuk melakukan kerjasama ekslusif, adapun detail kerjasamanya sebagai berikut:</p>
    </div>
    <div class="section" style="margin-top: 0; margin-bottom:0;">
        <h2>I. PIHAK PERTAMA, selaku pihak Telkomsel:</h2>
        <ol>
            @foreach ($benefit as $item)
            @if ($item === 'Fresh Money')
            <li style="font-size: 14px;">Memberikan benefit berupa fresh money. Sponsor akan memberikan sejumlah uang tunai yang akan digunakan untuk mendukung acara.</li>
            @elseif ($item === 'Cetak Banner')
            <li style="font-size: 14px;">Memberikan benefit berupa cetak banner. Sponsor akan mencetak dan menyediakan banner untuk acara sesuai kebutuhan.</li>
            @elseif ($item === 'Keuntungan Penjualan By.U')
            <li style="font-size: 14px;">Memberikan benefit berupa Keuntungan Penjualan By.U. Sponsor akan memberikan hasil keuntungan dari penjualan By.U.</li>
            @elseif ($item === 'Merchandise')
            <li style="font-size: 14px;">Memberikan benefit berupa Merchandise. Sponsor akan menyediakan produk Telkomsel untuk dibagikan kepada peserta acara.</li>
            @else
            <li style="font-size: 14px;">Benefit lain: {{ $item }}</li>
            @endif
            @endforeach
        </ol>
    </div>

    <div class="section" style="margin-top: 0; margin-bottom:10px;">
        <h2 style="margin-top: 0;">II. PIHAK KEDUA, sebagai pihak Instansi</h2>
        <ol>
            <li style="font-size: 14px;">Memberikan izin kepada Telkomsel untuk melakukan Sosialisasi Produk byU di lingkungan instansi sesuai dengan ketentuan yang berlaku.</li>
            <li style="font-size: 14px;">Memberikan izin kepada Telkomsel untuk melakukan penjualan produk di lingkungan instansi selama tidak mengganggu kegiatan operasional utama.</li>
        </ol>
    </div>

    <div class="section" style="margin-bottom: 0;">
        <p>Demikian berita acara kesepakatan ini dibuat rangkap dua, untuk digunakan sebagaimana mestinya.</p>
    </div>

    <div class="section" style="margin-top: 10px; margin-bottom:0; font-size: 14px;">
        Surabaya, {{ \Carbon\Carbon::parse($picSigned_date)->translatedFormat('d F Y') }}
    </div>

    <table style="width: 100%; text-align: center; border-collapse: collapse; margin-top:30px;">
        <tr>
            <!-- Kolom PIHAK PERTAMA -->
            <td style="width: 50%; vertical-align: top;">
                <strong style="margin: 0; white-space: nowrap; display: block; font-size: 14px; margin-bottom:10px;">PIHAK PERTAMA</strong>
                <strong style="margin: 0; white-space: nowrap; display: block; font-size: 14px;">PT TELKOMSEL</strong>
                <img src="{{ public_path('storage/' . $signature_PR) }}" alt="Tanda Tangan Pengaju" style="width: 200; height: 15%; margin: 0; display: block;">
                <strong style="margin: 0; white-space: nowrap; display: block; font-size: 14px;">{{$pr_name}}</strong>
            </td>
            <!-- Kolom PIHAK KEDUA -->
            <td style=" width: 50%; vertical-align: top; ">
                <strong style="margin: 0; white-space: nowrap; display: block; font-size: 14px; margin-bottom:10px">PIHAK KEDUA</strong>
                <strong style="margin: 0; white-space: nowrap; display: block; font-size: 14px;">{{$organizer_name}}</strong>
                <img src="{{ public_path('storage/' . $signature_path) }}" alt="Tanda Tangan PR" style="width: 200; height: 15%; margin: 0;">
                <strong style="margin: 0; white-space: nowrap; display: block; font-size: 14px;">{{$pic_name}}</strong>
            </td>
        </tr>
    </table>
</body>

</html>