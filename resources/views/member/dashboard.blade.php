@extends('layouts.app')

@section('title', 'Member Dashboard')
@section('page-title', 'My Dashboard')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/member-dashboard.css">
@endpush

@section('content')
    <!-- Stats Grid -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Total Training Sessions</h3>
            <div class="stat-value">{{ $stats['total_sessions'] ?? 0 }}</div>
        </div>
        <div class="stat-card success">
            <h3>Achievements</h3>
            <div class="stat-value">{{ $stats['achievements'] ?? 0 }}</div>
        </div>
        <div class="stat-card warning">
            <h3>Current Skill Level</h3>
            <div class="stat-value">{{ $stats['experience_level'] ?? 'N/A' }}</div>
        </div>
        <div class="stat-card danger">
            <h3>Recent Sessions</h3>
            <div class="stat-value">{{ $recentLogs->count() ?? 0 }}</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Recent Training -->
        <div class="card">
            <div class="card-header">
                <h2>Recent Training</h2>
                <a href="/member/history" class="btn btn-sm btn-primary" style="width: auto;">View All</a>
            </div>
            <div class="card-body">
                @if($recentLogs->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Distance</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentLogs as $log)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($log->session_date)->format('F d, Y') }}</td>
                                <td>{{ $log->distance }}m</td>
                                <td>{{ $log->total_score ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center" style="padding: 2rem; color: #666;">
                    <p>No training sessions yet.</p>
                    <a href="/member/create-log" class="btn btn-primary">➕ Add First Training Log</a>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="card-body">
                <div class="quick-actions-grid member-quick-actions">
                    <a href="/member/create-log" class="quick-action-btn">
                        <span class="quick-action-icon">➕</span>
                        <span class="quick-action-label">Log Training</span>
                    </a>
                    <a href="/member/history" class="quick-action-btn">
                        <span class="quick-action-icon">📚</span>
                        <span class="quick-action-label">Training History</span>
                    </a>
                    <a href="/member/profile" class="quick-action-btn">
                        <span class="quick-action-icon">👤</span>
                        <span class="quick-action-label">My Profile</span>
                    </a>
                    <a href="/member/achievements" class="quick-action-btn">
                        <span class="quick-action-icon">🏆</span>
                        <span class="quick-action-label">Achievements</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
