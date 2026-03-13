@extends('layouts.app')

@section('title', 'Member Achievements')
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
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; padding: 1rem 0;">
                @foreach ($achievements as $a)
                    <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; text-align: center; background: linear-gradient(135deg, #fff5e6 0%, #fff9f0 100%);">
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $a->badge_icon ?? '🏆' }}</div>
                        <h4 style="margin: 0.5rem 0;">{{ $a->title }}</h4>
                        <p style="margin: 0; font-size: 0.8rem; color: #666;">{{ $a->description }}</p>
                        @if (!empty($a->date_awarded))
                            <p style="margin: 0.5rem 0; font-size: 0.75rem; color: #999;">{{ \Carbon\Carbon::parse($a->date_awarded)->format('F d, Y') }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
