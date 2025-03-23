<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style-admin.css">
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="container">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <div class="white-box">
                <h2 style="margin-left: 20px;">{{ $title ?? 'Default Title' }}</h2>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>