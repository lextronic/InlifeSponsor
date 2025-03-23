<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Sponsorship Berhasil</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f7fc;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            color: #2D60FF;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
        }
        li {
            padding: 8px 0;
            font-size: 14px;
            line-height: 1.5;
        }
        .highlight {
            color: #2D60FF;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background-color: #2D60FF;
            color: #fff;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .cta-button:hover {
            background-color: #1a4e99;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 30px;
        }
        .footer p {
            margin-bottom: 5px;
        }
        .footer a {
            color: #2D60FF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .email-header {
            background-color: #2D60FF;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h2>Pengajuan Sponsorship Berhasil Diajukan!</h2>
            </div>

            <p>Halo <span class="highlight">{{ $pengajuan->pic_name }}</span>,</p>

            <p>Terima kasih telah mengajukan sponsorship untuk acara <span class="highlight">{{ $pengajuan->event_name }}</span>. Pengajuan Anda telah berhasil diajukan dan kami sedang memprosesnya. Berikut adalah detail pengajuan yang Anda ajukan:</p>

            <ul>
                <li><span class="highlight">Nama Event:</span> {{ $pengajuan->event_name }}</li>
                <li><span class="highlight">Deskripsi Event:</span> {{ $pengajuan->description }}</li>
                <li><span class="highlight">Tanggal Pelaksanaan:</span> {{ \Carbon\Carbon::parse($pengajuan->event_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($pengajuan->end_date)->format('d M Y') }}</li>
                <li><span class="highlight">Lokasi Acara:</span> {{ $pengajuan->location }}</li>
                <li><span class="highlight">Nama Penyelenggara:</span> {{ $pengajuan->organizer_name }}</li>
                <li><span class="highlight">Nama PIC Panitia:</span> {{ $pengajuan->pic_name }}</li>
                <li><span class="highlight">Nomor Telepon:</span> {{ $pengajuan->phone_number }}</li>
                <li><span class="highlight">Email:</span> {{ $pengajuan->email }}</li>
                <li><span class="highlight">Estimasi Partisipan:</span> {{ $pengajuan->estimated_participants }}</li>
            </ul>

            <p>Harap tunggu pemberitahuan lebih lanjut mengenai status pengajuan Anda. Kami akan menghubungi Anda jika ada informasi tambahan yang diperlukan.</p>

            <a href="{{ route('ajuan.index') }}" class="cta-button">Kembali ke Daftar Pengajuan</a>

            <div class="footer">
                <p>Terima kasih atas partisipasi Anda!</p>
                <p>Salam hangat,<br>Tim Sponsorship</p>
            </div>
        </div>
    </div>

</body>
</html>
