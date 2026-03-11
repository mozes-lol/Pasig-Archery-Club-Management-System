<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pasig Archery Club</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/auth.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        .auth-container {
            display: flex;
            min-height: 100vh;
            background: #FDFDFD;
        }

        .auth-card {
            display: flex;
            width: 100%;
            margin: 0;
            padding: 0;
            box-shadow: none;
            border-radius: 0;
            background: transparent;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>
</body>
</html>
