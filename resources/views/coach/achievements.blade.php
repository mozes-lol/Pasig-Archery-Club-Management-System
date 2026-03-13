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
                <p>Track your archer milestones and accomplishments</p>
            </div>
        </div>

        <!-- Achievements Grid -->
        <div class="achievements-grid">
            @foreach ($achievements as $a)
                <div class="achievement-card">
                    <div class="achievement-icon">
                        {!! $a->badge_icon ?: '<i class="fas fa-trophy"></i>' !!}
                    </div>
                    <div class="achievement-body">
                        <h3 class="achievement-title">{{ $a->title }}</h3>
                        <p class="achievement-description">{{ $a->description }}</p>
                        @if (!empty($a->date_awarded))
                            <p class="achievement-date">{{ \Carbon\Carbon::parse($a->date_awarded)->format('F d, Y') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
