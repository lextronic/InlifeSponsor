<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TelkomSupport</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins';
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img class="logo" src="image/logo.png" alt="logo" style="height: 150px; width:auto;" />
            </a>

            <!-- NAVIGASI LANDING -->
            <button class="navbar-toggler" style="border: 2px solid white; color:#ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" onmouseover="this.style.backgroundColor='#2D60FF'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='#2D60FF';">
                <span class="navbar-toggler-icon" style="width: 26px; height:26px;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#" style="font-weight:semibold; color:#ffffff; margin-right:10px;">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#benefit" aria-current="page" style="font-weight:semibold; color:#ffffff; margin-right:10px;">Benefit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentangKami" style="font-weight:semibold; color:#ffffff; margin-right:10px;">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tim" style="font-weight:semibold; color:#ffffff; margin-right:10px;">Lainnya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="font-weight:semibold; color:#ffffff; margin-right:10px;">Kontak</a>
                    </li>

                    <!-- MASUK/DAFTAR -->
                    <li class="d-flex align-items-center">
                        <a class="btn btn-light me-2" href="{{ route('register') }}" style="color:#2D60FF;" onmouseover="this.style.backgroundColor='#2D60FF'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='#2D60FF';">Daftar</a>
                        <a class="btn btn-light me-2" href="{{ route('login') }}" style="color:#2D60FF;" onmouseover="this.style.backgroundColor='#2D60FF'; this.style.color='white';" onmouseout="this.style.backgroundColor=''; this.style.color='#2D60FF';">Masuk</a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Beranda -->
    <section class="Beranda">
        <div class="grid-container">
            <div class="text-section">
                <h1>Dukung Event Anda Bersama Telkomsel!</h1>
                <p>Apakah Anda punya acara atau ide luar biasa yang ingin membawa perubahan besar?
                    Telkomsel siap membantu mewujudkan impian Anda melalui dukungan sponsorship yang penuh makna.</p>
                <a class="cta" href="{{ route('login') }}">
                    <span>Ajukan Sekarang</span>
                    <svg width="15px" height="10px" viewBox="0 0 13 10">
                        <polyline points="8 1 12 5 8 9"></polyline>
                    </svg>
                </a>
            </div>
            <div class="image-section align-items-center">
                <img src="image/ambasador1.png" alt="Image" class="about-img img-fluid" style="width: auto; height: auto;" />
            </div>
        </div>
    </section>

    <!-- Section Beranda 2 -->
    <section class="Beranda2" style="background-color:#516BF4;">
        <div class="grid-container-2">
            <div class="image-section-2 align-items-center">
                <img src="image/ambasador2.png" class="about-img img-fluid" style="width: auto; height: auto;">
            </div>

            <div class="text-section-2">
                <h1>Kenapa Harus Pilih Telkomsel Sebagai Sponsorship Di Event Kamu?</h1>
                <p>Di Telkomsel, kami percaya bahwa kolaborasi adalah kunci dari inovasi dan
                    perubahan positif. Melalui program sponsorship ini, kami ingin hadir di
                    setiap langkah penting Anda, mendukung acara, komunitas, dan proyek yang
                    membawa dampak nyata.</p>
            </div>
        </div>
    </section>

    <!-- Section Benefit -->
    <section class="Benefit" style="padding-top: 100px; padding-bottom:100px;" id="benefit">
        <div class="row justify-content-center">
            <div class="text-section" style="text-align: center; padding: 0; margin: 0;">
                <h1 style="font-size:35px;">Bentuk Dukungan Telkomsel</h1>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                <div class="col d-flex justify-content-center">
                    <div class="card" style="border: 2px solid #516BF4;">
                        <div class="card-icon">
                            <img src="image/freshmoney.png" width="16" height="16" fill="currentColor">
                        </div>
                        <h5 style="font-weight: bold;">Fresh Money</h5>
                        <p class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card" style="border: 2px solid #516BF4;">
                        <div class="card-icon">
                            <img src="image/freshmoney.png" width="16" height="16" fill="currentColor">
                        </div>
                        <h5 style="font-weight: bold;">Cetak Banner</h5>
                        <p class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card" style="border: 2px solid #516BF4;">
                        <div class="card-icon">
                            <img src="image/freshmoney.png" width="16" height="16" fill="currentColor">
                        </div>
                        <h5 style="font-weight: bold; text-align: center;">Keuntungan Penjualan By.U</h5>
                        <p class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card" style="border: 2px solid #516BF4;">
                        <div class="card-icon">
                            <img src="image/freshmoney.png" width="16" height="16" fill="currentColor">
                        </div>
                        <h5 style="font-weight: bold;">Merchandise</h5>
                        <p class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Tentang Kami -->
    <section class="TentangKami" style="background-color:#516BF4; padding-top:100px;" id="tentangKami">

        <h1 style="text-align: center; font-weight:bold; color:#ffffff; font-size:35px;">Tentang Kami</h1>
        <div class="grid-container">
            <div class="text-section">
                <p style="color:#ffffff;">Selamat datang di <span style="font-weight: bold;">TelkomSupport</span>, platform yang dikelola oleh Telkomsel
                    branch Surabaya untuk mendukung proses pengajuan sponsorship secara lebih mudah dan efisien.
                    Website ini dirancang untuk mempercepat dan menyederhanakan pengajuan sponsorship bagi masyarakat,
                    komunitas, serta perusahaan yang ingin berkolaborasi dalam berbagai kegiatan positif bersama Telkomsel.</p>
                <br>
                <h2 style="color:#ffffff; font-weight:bold; font-size:25px;">Misi Kami</h2>
                <div class="service-card">
                    <p>Memberikan dukungan bagi kegiatan sosial, edukatif, dan komersial yang sejalan dengan nilai-nilai Telkomsel.</p>
                </div>

                <div class="service-card">
                    <p>Memfasilitasi proses pengajuan sponsorship dengan sistem yang transparan dan responsif.</p>
                </div>

                <div class="service-card">
                    <p>Mengembangkan sinergi yang berkelanjutan antara Telkomsel dan komunitas Surabaya.</p>
                </div>
                <br>
                <h2 style="color:#ffffff; font-weight:bold; font-size:25px;">Layanan Kami</h2>
                <div class="service-card">
                    <i class="fas fa-file-alt"></i> <!-- Ikon untuk formulir -->
                    <p>Formulir Pengajuan Sponsorship Online yang praktis dan mudah digunakan.</p>
                </div>

                <div class="service-card">
                    <i class="fas fa-bell"></i> <!-- Ikon untuk notifikasi -->
                    <p>Notifikasi dan Update Status Pengajuan untuk memberikan informasi terkini mengenai progres pengajuan Anda.</p>
                </div>

                <div class="service-card">
                    <i class="fas fa-book"></i> <!-- Ikon untuk panduan -->
                    <p>Panduan dan Kriteria Pengajuan Sponsorship sebagai acuan untuk memastikan pengajuan Anda sesuai dengan kebijakan Telkomsel.</p>
                </div>
                <br>
                <p style="color:#ffffff;">Kami berharap, <span style="font-weight: bold;">TelkomSupport</span> dapat menjadi
                    jembatan yang memperkuat hubungan antara Telkomsel dan masyarakat Surabaya. Untuk informasi lebih lanjut atau
                    pertanyaan, silakan hubungi kami melalui halaman kontak.</p>

            </div>
            <div class="image-section align-items-center">
                <img src="image/TelkomSupportby.png" alt="Image" style="width: auto; height: auto;" />
            </div>
        </div>
    </section>

    <!-- Section Team -->
    <section class="Tim" style="padding-top: 100px; padding-bottom:100px;" id="tim">
        <div class="row justify-content-center">
            <div class="text-section" style="text-align: center; padding: 0; margin: 0;">
                <h1 style="font-size:35px;">Tim Pengembang TelkomSupport</h1>
                <h2 style="font-size:20px; color:#516BF4;">~ by Telkomsel Branch Surabaya ~</h2>
            </div>

            <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Salsa Diah Apriliani</span>
                        <p class="info">UPN "Veteran" Jawa Timur</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Septy Aulia Anggraeni</span>
                        <p class="info">Universitas Bina Nusantara</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Hawa Shabilla Fanfa</span>
                        <p class="info">UPN "Veteran" Jawa Timur</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Karina Dinda Artanti</span>
                        <p class="info">UPN "Veteran" Jawa Timur</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Aldi Bagus Hermawan</span>
                        <p class="info">UPN "Veteran" Jawa Timur</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Rakha Yolanda Puji Pratama</span>
                        <p class="info">UPN "Veteran" Jawa Timur</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card-tim">
                        <img src="image/icon-akun.svg" class="img-member">
                        <span>Abiyasa Ekki Pratista</span>
                        <p class="info">UPN "Veteran" Jawa Timur</p>
                        <div class="share">
                            <a href=""><img src="image/instagram.svg"></a>
                            <a href=""><img src="image/linkedin.svg"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Kontak -->
    <footer class="footer">
        <div class="footer-container">
            <h2>Kontak Kami</h2>
            <p><i class="fas fa-phone"></i> +62 123 4567 890</p>
            <p><i class="fas fa-envelope"></i> info@perusahaan.com</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Perusahaan | All Rights Reserved</p>
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="js/script-landing.js"></script> -->
</body>

</html>