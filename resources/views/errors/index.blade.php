<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        .error-page {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background-color: #f8f9fa;
            text-align: center;
        }
        .error-content {
            max-width: 600px;
            margin: 0 auto;
        }
        .error-title {
            font-size: 72px;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 24px;
            margin: 20px 0;
        }
        .error-actions {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="error-page">
    <div class="error-content">
        <h1 class="error-title">Access Denied</h1>
        <p class="error-message">You do not have permission to access this page.</p>
        <div class="error-actions">
            <a href="{{ route('landing') }}" class="btn btn-primary">Go to Homepage</a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
