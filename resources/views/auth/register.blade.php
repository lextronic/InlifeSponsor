<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register TelkomSupport</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/style-login.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: Poppins;
        overflow-x: hidden;
    }
</style>

<body style="align-items: center;">
    <div class="header-login" style="background-color: #516BF4;">
        <div class="row align-items-center p-3">
            <div class="col-4">
                <a href="{{ route('landing') }}" class="btn custom-back-button text-white d-flex align-items-center">
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

    <div style="text-align: center; margin-top:50px;">
        <h1 class="h3 mb-3 fw-bold">Selamat Datang!</h1>
        <p>Silahkan isi data kamu untuk membuat akun TelkomSupport.</p>
    </div>

    <div class="container">
        <div class="p-4" style="background-color:#E5E9FE; border-radius: 15px; width:40%;">
            <img src="image/TelkomSupportbybiru.png" alt="Animasi" class="img-fluid" style="display: block; margin: 0 auto 30px auto; width: 50%;">
            <form action="{{ route('register.save') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" style="border-color: #516BF4;" class="form-control" id="nameuser" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" style="border-color: #516BF4;" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="address">Alamat</label>
                    <input type="text" style="border-color: #516BF4;" class="form-control" id="address" name="address" placeholder="Enter your address" required>
                </div>
                <div class="form-group mb-3">
                    <label for="level">Pekerjaan</label>
                    <select style="border-color: #516BF4;" class="form-control" id="level" name="level" required>
                        <option value="">Pilih Pekerjaan</option>
                        <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                        <option value="Event Organizer">Event Organizer</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" style="border-color: #516BF4;" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="button" id="togglePassword">
                            <img src="{{ asset('image/eye-open.svg') }}" alt="Eye open" class="eye-close" id="eyeIcon" style="width: 24px; height: 24px;">
                        </button>
                    </div>
                    <!-- Alert Message for Password -->
                    <p id="passwordAlert" style="font-size: 14px; color: red; display: none; margin:10px; margin-left:0;">
                        *Kata sandi harus terdiri minimal 8 karakter.
                    </p>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" style="border-color: #516BF4;" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Confirm your password" required>
                        <button type="button" class="button" id="togglePasswordConfirm">
                            <img src="{{ asset('image/eye-open.svg') }}" alt="Eye open" class="eye-close" id="eyeIconConfirm" style="width: 24px; height: 24px;">
                        </button>
                    </div>

                    <p id="confirmPasswordAlert" style="font-size: 14px; color: red; display: none; margin:10px; margin-left:0;">
                        *Kata sandi yang anda massukan tidak cocok.
                    </p>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary w-50 rounded-pill">Register</button>
                </div>
            </form>
            <small class="d-block text-center mt-3">Sudah punya akun? <a href="/login">Login</a></small>
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
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');
        const passwordAlert = document.getElementById('passwordAlert');
        const confirmPasswordAlert = document.getElementById('confirmPasswordAlert');

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

        togglePasswordConfirm.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            if (type === 'password') {
                eyeIconConfirm.src = "image/eye-open.svg";
                togglePasswordConfirm.classList.remove('active');
            } else {
                eyeIconConfirm.src = "image/eye-close.svg";
                togglePasswordConfirm.classList.add('active');
            }
        });

        passwordInput.addEventListener('input', function() {
            // Jika panjang password kurang dari 6, tampilkan alert
            if (passwordInput.value !== '' && passwordInput.value.length < 8) {
                passwordAlert.style.display = 'block'; // Menampilkan pemberitahuan
            } else {
                passwordAlert.style.display = 'none'; // Menyembunyikan pemberitahuan
            }
        });

        // Confirm password validation
        confirmPasswordInput.addEventListener('input', function() {
            if (confirmPasswordInput.value !== passwordInput.value && confirmPasswordInput.value !== '') {
                confirmPasswordAlert.style.display = 'block'; // Menampilkan pemberitahuan jika tidak sama
            } else {
                confirmPasswordAlert.style.display = 'none'; // Menyembunyikan pemberitahuan jika sama
            }
        });
    });
</script>

</html>