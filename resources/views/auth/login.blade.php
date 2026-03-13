@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="login-container">
        <!-- Decorative Arch -->
        <svg class="login-arch" viewBox="0 0 1200 400" preserveAspectRatio="none">
            <defs>
                <linearGradient id="archGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#e8f0ff;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#f8f9fa;stop-opacity:1" />
                </linearGradient>
            </defs>
            <path d="M 0 0 Q 600 300 1200 0 L 1200 400 L 0 400 Z" fill="url(#archGradient)"/>
        </svg>

        <!-- Left Side - Logo -->
        <div class="login-left">
            <div class="login-left-content">
                <div class="logo-box">
                    <img src="/images/PACLogo.png" alt="Pasig Archery Club Logo">
                </div>
            </div>
        </div>

        <!-- Curved Divider -->
        <svg class="login-curve" viewBox="0 0 100 500" preserveAspectRatio="none">
            <path d="M0,0 Q20,250 0,500 L100,500 L100,0 Z" fill="#f8f9fa"/>
        </svg>

        <!-- Right Side - Form -->
        <div class="login-right">
            <div class="login-form-wrapper">
                <h1 class="welcome-text">Welcome Back</h1>
                <p class="welcome-subtitle">Sign in to your account</p>
                <h2>Login</h2>
                <div class="form-divider"></div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-left: 1rem; margin-bottom: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="/login" class="authentication-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="Enter your email" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your password" 
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility()" title="Show/Hide password">
                                <svg id="eyeOpenIcon" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg id="eyeClosedIcon" class="eye-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">Login</button>

                    <div class="form-link">
                        Don't have an account? <a href="/register">Create one here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');
            const eyeClosedIcon = document.getElementById('eyeClosedIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpenIcon.classList.add('hidden');
                eyeClosedIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpenIcon.classList.remove('hidden');
                eyeClosedIcon.classList.add('hidden');
            }
        }

        // Move focus to password field when Enter is pressed on email field
        document.getElementById('email').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('password').focus();
            }
        });

        // Submit form when Enter is pressed on password field
        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.querySelector('.authentication-form').submit();
            }
        });
    </script>
@endsection
