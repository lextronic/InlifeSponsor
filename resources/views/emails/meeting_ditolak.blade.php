<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Ditolak</title>
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
            color: #FF3D3D; /* Warna merah untuk penolakan */
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .highlight {
            color: #FF3D3D;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background-color: #FF3D3D; /* Warna merah untuk tombol */
            color: #fff;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .cta-button:hover {
            background-color: #d13636;
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
            color: #FF3D3D;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .email-header {
            background-color: #FF3D3D; /* Warna merah untuk header */
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
                <h2>Pengajuan Anda Telah Ditolak</h2>
            </div>

            <p>Halo <span class="highlight">{{ $pengajuan->user->name }}</span>,</p>

            <p>Dengan sangat menyesal, kami memberitahukan bahwa pengajuan sponsorship Anda untuk acara <span class="highlight">{{ $pengajuan->event_name }}</span> telah ditolak.</p>

            <p>Berikut adalah alasan penolakan:</p>

            <blockquote>
                <p><strong>Alasan Penolakan:</strong></p>
                <p>{{ $pengajuan->catatan_meeting }}</p>
            </blockquote>

            <p>Terima kasih telah mengajukan proposal kepada kami. Meskipun pengajuan Anda ditolak kali ini, kami tetap menghargai waktu dan usaha yang telah Anda lakukan.</p>

            <p>Salam,<br> Tim Sponsorship</p>

            <div class="footer">
                <p>Terima kasih telah bergabung!<br>Tim Kami</p>
            </div>
        </div>
    </div>

</body>
</html>
