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
        
        /* Top Right Loading Throbber - Centered below header */
        .top-right-loader {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 16px 32px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .top-right-loader.active {
            opacity: 1;
            visibility: visible;
        }
        
        .top-right-loader .throbber {
            width: 40px;
            height: 40px;
            border: 3px solid #e0e0e0;
            border-top-color: #3498db;
            border-radius: 50%;
            animation: throbber-spin 0.8s linear infinite;
        }
        
        .top-right-loader .throbber-text {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }
        
        @keyframes throbber-spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Top Right Loading Throbber -->
    <div class="top-right-loader" id="topRightLoader">
        <div class="throbber"></div>
        <span class="throbber-text" id="topRightLoaderText">Loading...</span>
    </div>

    <!-- User Profile Bar -->
    <div class="user-profile-bar">
        <div class="user-profile">
            <div class="profile-avatar">{{ substr(Session::get('first_name') ?? 'U', 0, 1) }}{{ substr(Session::get('last_name') ?? '', 0, 1) }}</div>
            <div class="profile-info">
                <p class="profile-name">{{ Session::get('first_name') ?? 'User' }} {{ Session::get('last_name') ?? '' }}</p>
                <p class="profile-email">{{ Session::get('email') ?? 'user@example.com' }}</p>
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
    <script>
        // Top Right Loader JavaScript
        window.TopRightLoader = {
            loader: null,
            textElement: null,
            counter: 0,
            timeout: null,

            init: function() {
                this.loader = document.getElementById('topRightLoader');
                this.textElement = document.getElementById('topRightLoaderText');
            },

            show: function(message = 'Loading...') {
                if (!this.loader) this.init();
                if (this.textElement) {
                    this.textElement.textContent = message;
                }
                this.loader.classList.add('active');
                this.counter++;
            },

            hide: function() {
                if (!this.loader) this.init();
                this.counter--;
                if (this.counter <= 0) {
                    this.loader.classList.remove('active');
                    this.counter = 0;
                }
            },

            setMessage: function(msg) {
                if (this.textElement) {
                    this.textElement.textContent = msg;
                }
            },

            // Show with auto-hide after delay
            showWithTimeout: function(message, delay) {
                this.show(message);
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.hide();
                }, delay || 3000);
            }
        };

        // Auto-show loader on form submissions
        document.addEventListener('DOMContentLoaded', function() {
            TopRightLoader.init();
            
            // Show loader when any form is submitted
            document.addEventListener('submit', function(e) {
                // Only show for non-login forms (login has its own handling)
                if (e.target.classList.contains('authentication-form')) {
                    return;
                }

                // Allow opt-out for modal forms or custom loaders
                if (e.target.hasAttribute('data-no-top-loader')) {
                    return;
                }

                TopRightLoader.show('Processing...');
            });

            // Show loader on link clicks that navigate to same page with data
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && link.href.includes(window.location.pathname)) {
                    TopRightLoader.show('Loading...');
                }
            });
        });
    </script>
</body>
</html>
