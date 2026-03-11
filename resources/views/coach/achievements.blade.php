@extends('layouts.app')

@section('title', 'Coach Achievements')
@section('page-title', 'My Achievements')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-achievements.css">
@endpush

@section('content')
    <div class="achievements-management">
        <!-- Header -->
        <div class="management-header">
            <div class="header-text">
                <h1>My Achievements</h1>
                <p>Track your coaching milestones and accomplishments</p>
            </div>
        </div>

        <!-- Achievements Grid -->
        <div class="achievements-grid">
            <!-- Achievement 1 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">Top Coach</h3>
                    <p class="achievement-description">2025 Top Rated Coach</p>
                    <p class="achievement-date">December 15, 2025</p>
                </div>
            </div>

            <!-- Achievement 2 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">10 Athletes Trained</h3>
                    <p class="achievement-description">Coached 10 athletes to achievement</p>
                    <p class="achievement-date">November 20, 2025</p>
                </div>
            </div>

            <!-- Achievement 3 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">100 Sessions</h3>
                    <p class="achievement-description">Completed 100 training sessions</p>
                    <p class="achievement-date">October 10, 2025</p>
                </div>
            </div>

            <!-- Achievement 4 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">Perfect Scores</h3>
                    <p class="achievement-description">5 athletes score perfect in competition</p>
                    <p class="achievement-date">September 5, 2025</p>
                </div>
            </div>

            <!-- Achievement 5 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">Award Winner</h3>
                    <p class="achievement-description">Best Coach Award 2025</p>
                    <p class="achievement-date">August 30, 2025</p>
                </div>
            </div>

            <!-- Achievement 6 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">Mentorship Excellence</h3>
                    <p class="achievement-description">Mentored 3 junior coaches</p>
                    <p class="achievement-date">July 15, 2025</p>
                </div>
            </div>

            <!-- Achievement 7 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-gem"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">Excellence in Teaching</h3>
                    <p class="achievement-description">Avg rating 4.8/5.0 from athletes</p>
                    <p class="achievement-date">June 1, 2025</p>
                </div>
            </div>

            <!-- Achievement 8 -->
            <div class="achievement-card">
                <div class="achievement-icon">
                    <i class="fas fa-sparkles"></i>
                </div>
                <div class="achievement-body">
                    <h3 class="achievement-title">Consistent Excellence</h3>
                    <p class="achievement-description">More than 1 year in club</p>
                    <p class="achievement-date">May 20, 2025</p>
                </div>
            </div>
        </div>
    </div>
@endsection