<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Telkomsel | Lupa Kata Sandi</title>
    <!-- css -->
    <link rel="stylesheet" href="css/style-login.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>
<style>
    body {
        font-family: poppins;
        overflow-x: hidden;
    }
</style>

<body style="align-items: center;">
    <div class="header-login" style="background-color: #516BF4;">
        <div class="row align-items-center p-3">
            <div class="col-4">
                <a href="{{ route('login') }}" class="btn custom-back-button text-black d-flex align-items-center">
                    <div class="sign me-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.75 18.75L9 12L15.75 5.25" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="text" style="color: white;">Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 80px;">
        <h1 class="h3 mb-3 fw-bold">Lupa Kata Sandi</h1>
    </div>

    <div class="container">
        @if (!session('email') && !session('otp_sent'))
            <div class="form-container p-4" style="background-color:#E5E9FE; border-radius: 15px; width:40%;">
                <strong style="margin-bottom: 10px;">Masukkan email kamu yang sudah terdaftar.</strong>
                <form action="{{ route('send.otp') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Masukkan Email</label>
                        <input type="email" name="email" id="email" class="form-control" style="border-color: #516BF4;" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim OTP</button>
                </form>
            </div>
        @elseif (session('otp_sent') && !session('otp_verified'))
            <div class="form-container p-4" style="background-color:#E5E9FE; border-radius: 15px; width:40%;">
                <strong class="d-block mb-3">Masukkan kode OTP yang telah dikirim ke email kamu.</strong>
                <form action="{{ route('verify.otp') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="otp" class="form-label">Kode OTP</label>
                        <input type="text" name="otp" id="otp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Verifikasi OTP</button>
                </form>

                <!-- Tombol untuk mengirim ulang OTP -->
                <div class="mt-3 text-center">
                    <form action="{{ route('resend.otp') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}"> <!-- Mengirimkan email ke server -->
                        <button type="submit" class="btn btn-link p-0">Kirim ulang OTP</button>
                    </form>
                </div>
            </div>
        @elseif (session('otp_verified'))
            <div class="form-container p-4" style="background-color:#E5E9FE; border-radius: 15px; width:40%;">
                <strong style="margin-bottom: 10px;">Buat kata sandi baru kamu.</strong>
                <form action="{{ route('save.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="email" class="form-control" value="{{ session('email') }}" style="border-color: #516BF4;" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password" class="form-control" style="border-color: #516BF4;" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" style="border-color: #516BF4;" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Kata Sandi</button>
                </form>
                
            </div>
        @else
            <p>Harap verifikasi OTP terlebih dahulu untuk melanjutkan.</p>
        @endif
    </div>
</body>
<script src="js/login.js"></script>

</html>
