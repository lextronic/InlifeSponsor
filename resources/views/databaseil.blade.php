<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel MySQL DB Inlife</title>
</head>
<body>
    <div>
        @if (\Illuminate\Support\Facades\DB::connection()->getPdo())
            <p>Successfully Connected to DB. DB Name: {{ \Illuminate\Support\Facades\DB::connection()->getDatabase() }}</p>
        @else
            <p>Failed to connect to the database.</p>
        @endif
    </div>
</body>
</html>
