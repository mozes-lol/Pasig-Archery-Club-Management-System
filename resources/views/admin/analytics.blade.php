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
                <div class="stat-number">245</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">24</div>
                <div class="stat-label">New Users Per Month</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">156</div>
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
                <div style="padding: 1rem 0;">
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Members</span>
                            <strong>210 (86%)</strong>
                        </div>
                        <div style="height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: 86%; background: #10b981;"></div>
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Coaches</span>
                            <strong>12 (5%)</strong>
                        </div>
                        <div style="height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: 5%; background: #f59e0b;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Admins</span>
                            <strong>2 (1%)</strong>
                        </div>
                        <div style="height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div style="height: 100%; width: 1%; background: #ef4444;"></div>
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
                    <div style="flex: 1; background: #667eea; height: 60%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">22</div>
                    <div style="flex: 1; background: #764ba2; height: 75%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">28</div>
                    <div style="flex: 1; background: #667eea; height: 45%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">17</div>
                    <div style="flex: 1; background: #764ba2; height: 90%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">34</div>
                    <div style="flex: 1; background: #667eea; height: 55%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">21</div>
                    <div style="flex: 1; background: #764ba2; height: 80%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">30</div>
                    <div style="flex: 1; background: #667eea; height: 70%; display: flex; align-items: flex-end; justify-content: center; border-radius: 4px; color: white; font-size: 0.75rem;">26</div>
                </div>
                <div style="display: flex; justify-content: space-around; font-size: 0.8rem; color: #666; margin-top: 1rem;">
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                    <span>Sun</span>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
