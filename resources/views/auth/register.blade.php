@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="register-container">
        <!-- Decorative Arch -->
        <svg class="register-arch" viewBox="0 0 1200 400" preserveAspectRatio="none">
            <defs>
                <linearGradient id="regArchGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#e8f0ff;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#f8f9fa;stop-opacity:1" />
                </linearGradient>
            </defs>
            <path d="M 0 0 Q 600 300 1200 0 L 1200 400 L 0 400 Z" fill="url(#regArchGradient)"/>
        </svg>

        <!-- Left Side - Logo -->
        <div class="register-left">
            <div class="register-left-content">
                <div class="logo-box">
                    <img src="/images/PACLogo.png" alt="Pasig Archery Club Logo">
                </div>
            </div>
        </div>

        <!-- Curved Divider -->
        <svg class="register-curve" viewBox="0 0 100 500" preserveAspectRatio="none">
            <path d="M0,0 Q20,250 0,500 L100,500 L100,0 Z" fill="#f8f9fa"/>
        </svg>

        <!-- Right Side - Form -->
        <div class="register-right">
            <div class="register-form-wrapper">
                <h1 class="welcome-text">Join Us</h1>
                <p class="welcome-subtitle">Create your account</p>
                <h2>Register</h2>
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

                <form method="POST" action="/register" class="authentication-form">
                    @csrf

                    <!-- First Name and Last Name Side by Side -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input 
                                type="text" 
                                id="firstname" 
                                name="firstname" 
                                value="{{ old('firstname') }}"
                                placeholder="First name" 
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input 
                                type="text" 
                                id="lastname" 
                                name="lastname" 
                                value="{{ old('lastname') }}"
                                placeholder="Last name" 
                                required
                            >
                        </div>
                    </div>

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
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password', 'eyeOpenIcon', 'eyeClosedIcon')" title="Show/Hide password">
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

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Confirm your password" 
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password_confirmation', 'eyeOpenIcon2', 'eyeClosedIcon2')" title="Show/Hide password">
                                <svg id="eyeOpenIcon2" class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg id="eyeClosedIcon2" class="eye-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-register">Register</button>

                    <div class="form-link">
                        Already have an account? <a href="/login">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, openIconId, closedIconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeOpenIcon = document.getElementById(openIconId);
            const eyeClosedIcon = document.getElementById(closedIconId);
            
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
    </script>
@endsection
