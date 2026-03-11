@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')
@push('page-styles')
<link rel="stylesheet" href="/css/pages/member-profile.css">
@endpush
@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Profile Info -->
        <div class="card">
            <div class="card-header">
                <h2>Profile Information</h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Full Name</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">Maria Rodriguez</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Email</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">maria.rodriguez@example.com</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Member Since</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">January 15, 2025</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Current Skill Level</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">Intermediate</p>
                </div>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-primary" style="width: 100%; margin: 0;">✏️ Edit Profile</a>
            </div>
        </div>

        <!-- Training Stats -->
        <div class="card">
            <div class="card-header">
                <h2>Training Statistics</h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Total Training Hours</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">45 hours</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Training Sessions</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">22 sessions</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Average Duration</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">2 hours per session</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="color: #999; font-size: 0.8rem; margin: 0;">Last Training</p>
                    <p style="color: #333; font-weight: 500; margin: 0;">March 10, 2026</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="card" style="margin-top: 1.5rem;">
        <div class="card-header">
            <h2>Change Password</h2>
        </div>
        <form method="POST" action="#" class="card-body">
            @csrf
            
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin: 0;">🔐 Update Password</button>
        </form>
    </div>
@endsection