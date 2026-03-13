@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/admin-dashboard.css">
@endpush

@section('content')
    <!-- Stats Grid -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Total Members</h3>
            <div class="stat-value">{{ $stats['total_members'] ?? 0 }}</div>
        </div>
        <div class="stat-card success">
            <h3>Active Coaches</h3>
            <div class="stat-value">{{ $stats['active_coaches'] ?? 0 }}</div>
        </div>
        <div class="stat-card warning">
            <h3>Pending Applications</h3>
            <div class="stat-value">{{ $stats['pending_users'] ?? 0 }}</div>
        </div>
        <div class="stat-card danger">
            <h3>Training Events This Month</h3>
            <div class="stat-value">{{ $stats['training_this_month'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Recent Users Card -->
        <div class="card">
            <div class="card-header">
                <h2>Recent Members</h2>
                <a href="/admin/users" class="btn btn-sm btn-primary" style="width: auto;">View All</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentUsers as $user)
                            <tr>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->role_id }}</td>
                                <td><span class="status-badge {{ $user->status }}">{{ ucfirst($user->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="card">
            <div class="card-header">
                <h2>Quick Actions</h2>
            </div>
            <div class="card-body">
                <div class="quick-actions-grid">
                    <a href="/admin/users" class="quick-action-btn">
                        <span class="quick-action-icon">👥</span>
                        <span class="quick-action-label">Manage Users</span>
                    </a>
                    <a href="/admin/achievements" class="quick-action-btn">
                        <span class="quick-action-icon">🏆</span>
                        <span class="quick-action-label">Achievements</span>
                    </a>
                    <a href="/admin/analytics" class="quick-action-btn">
                        <span class="quick-action-icon">📈</span>
                        <span class="quick-action-label">Analytics</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
