@extends('layouts.app')

@section('title', 'Archer List')
@section('page-title', 'Archers')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-archers.css">
@endpush

@section('content')
    <div class="archers-management">
        <!-- Header -->
        <div class="management-header">
            <div class="header-text">
                <h1>Archer List</h1>
                <p>Overview of currently active and inactive archers</p>
            </div>
        </div>

        <!-- Archers Grid -->
        <div class="archers-grid">
            <!-- Archer Card 1 -->
            <div class="archer-card">
                <div class="archer-card-header">
                    <div class="archer-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <button class="archer-menu-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="archer-card-body">
                    <h3 class="archer-name">Juan Dela Cruz</h3>
                    <p class="archer-rank">Gold Archer</p>
                    <div class="archer-status">
                        <span class="status-indicator active"></span>
                        <span class="status-text">Active Now</span>
                    </div>
                    <div class="archer-meta">
                        <div class="meta-item">
                            <i class="fas fa-medal"></i>
                            <span>#2 Ranking</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>Jan 15, 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archer Card 2 -->
            <div class="archer-card">
                <div class="archer-card-header">
                    <div class="archer-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <button class="archer-menu-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="archer-card-body">
                    <h3 class="archer-name">Juan Dela Cruz</h3>
                    <p class="archer-rank">Bronze Archer</p>
                    <div class="archer-status">
                        <span class="status-indicator in-range"></span>
                        <span class="status-text">In Range</span>
                    </div>
                    <div class="archer-meta">
                        <div class="meta-item">
                            <i class="fas fa-medal"></i>
                            <span>#5 Ranking</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>Mar 22, 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archer Card 3 -->
            <div class="archer-card">
                <div class="archer-card-header">
                    <div class="archer-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <button class="archer-menu-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="archer-card-body">
                    <h3 class="archer-name">Juan Dela Cruz</h3>
                    <p class="archer-rank">Silver Archer</p>
                    <div class="archer-status">
                        <span class="status-indicator inactive"></span>
                        <span class="status-text">Inactive</span>
                    </div>
                    <div class="archer-meta">
                        <div class="meta-item">
                            <i class="fas fa-medal"></i>
                            <span>#8 Ranking</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>Jun 10, 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archer Card 4 -->
            <div class="archer-card">
                <div class="archer-card-header">
                    <div class="archer-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <button class="archer-menu-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="archer-card-body">
                    <h3 class="archer-name">Juan Dela Cruz</h3>
                    <p class="archer-rank">Silver Archer</p>
                    <div class="archer-status">
                        <span class="status-indicator inactive"></span>
                        <span class="status-text">Inactive</span>
                    </div>
                    <div class="archer-meta">
                        <div class="meta-item">
                            <i class="fas fa-medal"></i>
                            <span>#12 Ranking</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>May 05, 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archer Card 5 -->
            <div class="archer-card">
                <div class="archer-card-header">
                    <div class="archer-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <button class="archer-menu-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="archer-card-body">
                    <h3 class="archer-name">Juan Dela Cruz</h3>
                    <p class="archer-rank">Silver Archer</p>
                    <div class="archer-status">
                        <span class="status-indicator in-range"></span>
                        <span class="status-text">In Range</span>
                    </div>
                    <div class="archer-meta">
                        <div class="meta-item">
                            <i class="fas fa-medal"></i>
                            <span>#3 Ranking</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>Feb 14, 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archer Card 6 -->
            <div class="archer-card">
                <div class="archer-card-header">
                    <div class="archer-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <button class="archer-menu-btn">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="archer-card-body">
                    <h3 class="archer-name">Juan Dela Cruz</h3>
                    <p class="archer-rank">Bronze Archer</p>
                    <div class="archer-status">
                        <span class="status-indicator inactive"></span>
                        <span class="status-text">Inactive</span>
                    </div>
                    <div class="archer-meta">
                        <div class="meta-item">
                            <i class="fas fa-medal"></i>
                            <span>#7 Ranking</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>Apr 08, 2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection