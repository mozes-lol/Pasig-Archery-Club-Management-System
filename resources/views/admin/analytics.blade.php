@extends('layouts.app')

@section('title', 'Analytics Report')
@section('page-title', 'Analytics Report')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/admin-analytics.css">
@endpush

@section('content')
    <div class="analytics-page">
        <!-- Header -->
        <div class="management-header">
            <div class="header-text">
                <h1>Analytics Report</h1>
                <p>view training statistics and member activity reports</p>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['new_users_month'] ?? 0 }}</div>
                <div class="stat-label">New Users Per Month</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['active_sessions_month'] ?? 0 }}</div>
                <div class="stat-label">Active Sessions Per Month</div>
            </div>
        </div>

    <!-- Reports Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
        <!-- Role Distribution -->
        <div class="card">
            <div class="card-header">
                <h2>User Distribution by Role</h2>
            </div>
            <div class="card-body">
                @php
                    $total = max(1, ($stats['members'] ?? 0) + ($stats['coaches'] ?? 0) + ($stats['admins'] ?? 0));
                    $memberPct = round((($stats['members'] ?? 0) / $total) * 100);
                    $coachPct = round((($stats['coaches'] ?? 0) / $total) * 100);
                    $adminPct = round((($stats['admins'] ?? 0) / $total) * 100);
                @endphp
                <div style="padding: 1rem 0;">
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Members</span>
                            <strong>{{ $stats['members'] ?? 0 }} ({{ $memberPct }}%)</strong>
                        </div>
                        <div style="height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $memberPct }}%; background: #10b981;"></div>
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Coaches</span>
                            <strong>{{ $stats['coaches'] ?? 0 }} ({{ $coachPct }}%)</strong>
                        </div>
                        <div style="height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $coachPct }}%; background: #f59e0b;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Admins</span>
                            <strong>{{ $stats['admins'] ?? 0 }} ({{ $adminPct }}%)</strong>
                        </div>
                        <div style="height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $adminPct }}%; background: #ef4444;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Training Activity -->
        <div class="card">
            <div class="card-header">
                <h2>Training Activity (Last 7 Days)</h2>
            </div>
            <div class="card-body">
                <div style="height: 150px; display: flex; align-items: flex-end; gap: 0.5rem; padding: 1rem 0;">
                    @for($i = 0; $i < 7; $i++)
                    <div style="flex: 1; background: {{ $i % 2 == 0 ? '#667eea' : '#764ba2' }}; height: {{ $stats['last7DaysHeights'][$i] }}%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem; min-height: 20px;">{{ $stats['last7DaysData'][$i] }}</div>
                    @endfor
                </div>
                <div style="display: flex; justify-content: space-around; font-size: 0.8rem; color: #666; margin-top: 1rem;">
                    @foreach($stats['last7Days'] as $day)
                    <span>{{ $day }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
