<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pasig Archery Club</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/brands.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/app.css">
    @stack('page-styles')
    <style>
        body {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- User Profile Bar -->
    <div class="user-profile-bar">
        <div class="user-profile">
            <div class="profile-avatar">{{ substr(auth()->user()?->name ?? 'User', 0, 1) }}</div>
            <div class="profile-info">
                <p class="profile-name">{{ auth()->user()?->name ?? 'User' }}</p>
                <p class="profile-email">{{ auth()->user()?->email ?? 'user@example.com' }}</p>
            </div>
        </div>
    </div>

    <div class="main-container">
        <x-sidebar />

        <!-- MAIN CONTENT -->
        <main class="main-content" id="main-content">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <script>
                // Update main-content class when sidebar is toggled
                function updateMainContentClass() {
                    const sidebar = document.getElementById('sidebar');
                    const mainContent = document.getElementById('main-content');
                    if (sidebar && mainContent) {
                        if (sidebar.classList.contains('collapsed')) {
                            mainContent.classList.add('sidebar-collapsed');
                        } else {
                            mainContent.classList.remove('sidebar-collapsed');
                        }
                    }
                }
                
                // Call on page load
                window.addEventListener('DOMContentLoaded', updateMainContentClass);
            </script>
            @yield('content')
        </main>
    </div>

    <!-- Global Archery Loader -->
    <x-archery-loader fullscreen label="LOADING" message="Processing your request..." />

    <script src="{{ asset('build/assets/app.js') }}"></script>
</body>
</html>
