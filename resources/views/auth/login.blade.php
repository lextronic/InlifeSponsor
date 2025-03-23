<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Telkomsel | Masuk </title>
    <!-- css -->
    <link rel="stylesheet" href="css/style-login.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <a href="{{ route('landing') }}" class="btn custom-back-button text-black d-flex align-items-center">
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

    <div style="text-align: center; margin-top:80px;">
        <h1 class="h3 mb-3 fw-bold">Selamat Datang!</h1>
        <p>Silahkan masuk dengan akun yang terdaftar.</p>
    </div>

    <div class="container">
        <div class="p-4 " style="background-color:#E5E9FE; border-radius: 15px; width:40%;">
            <img src="image/TelkomSupportbybiru.png" alt="Animasi" class="img-fluid" style="display: block; margin: 0 auto 30px auto; width: 50%;">
            @if(session('gagal'))
            <div class="alert alert-danger mt-2" style="color:red;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
                {{session('gagal')}}
            </div>
            @endif
            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" style="border-color: #516BF4;" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" required autocomplete="off">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" style="border-color: #516BF4;" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan kata sandi" required autocomplete="off">

                        <button type="button" class="button" id="togglePassword">
                            <img src="{{ asset('image/eye-open.svg') }}" alt="Eye open" class="eye-close" id="eyeIcon" style="width: 24px; height: 24px;">
                        </button>
                    </div>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <a href="{{ route('forgot.password') }}" class="text-end text-decoration-none d-block fw-bold" style="font-size: 15px;">Lupa kata sandi?</a>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary w-50 rounded-pill text-center" style="margin-top: 50px;">Masuk</button>
                </div>

            </form>
            <small class="d-block text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></small>

        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kosongkan input email dan password
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';

        // Script toggle password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                eyeIcon.src = "image/eye-open.svg";
                togglePassword.classList.remove('active');
            } else {
                eyeIcon.src = "image/eye-close.svg";
                togglePassword.classList.add('active');
            }
        });
    });
</script>

</html>