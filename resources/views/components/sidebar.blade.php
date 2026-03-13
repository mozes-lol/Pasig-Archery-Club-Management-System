<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="/images/PACLogo.png" alt="Pasig Archery Club Logo" class="sidebar-logo-img">
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>

    <nav class="sidebar-menu">
        @php
            $currentSection = request()->segment(1); // Get 'admin', 'coach', or 'member'
        @endphp

        @if($currentSection === 'admin')
            <!-- ADMIN SECTION -->
            <h3>Admin</h3>
            <li><a href="/admin/analytics" class="@if(request()->is('admin') || request()->is('admin/analytics')) active @endif"><span class="icon"><i class="fas fa-chart-line"></i></span><span class="label">Analytics Report</span></a></li>
            <li><a href="/admin/users" class="@if(request()->is('admin/users')) active @endif"><span class="icon"><i class="fas fa-users"></i></span><span class="label">User Management</span></a></li>
            <li><a href="/admin/achievements" class="@if(request()->is('admin/achievements')) active @endif"><span class="icon"><i class="fas fa-trophy"></i></span><span class="label">Achievements</span></a></li>

        @elseif($currentSection === 'coach')
            <!-- COACH SECTION -->
            <h3>Coach</h3>
            <li><a href="/coach/training-logs" class="@if(request()->is('coach') || request()->is('coach/training-logs')) active @endif"><span class="icon"><i class="fas fa-book"></i></span><span class="label">Training Logs</span></a></li>
            <li><a href="/coach/archers" class="@if(request()->is('coach/archers')) active @endif"><span class="icon"><i class="fas fa-bullseye"></i></span><span class="label">Archers List</span></a></li>
            <li><a href="/coach/profile" class="@if(request()->is('coach/profile')) active @endif"><span class="icon"><i class="fas fa-user"></i></span><span class="label">My Profile</span></a></li>
            <li><a href="/coach/achievements" class="@if(request()->is('coach/achievements')) active @endif"><span class="icon"><i class="fas fa-trophy"></i></span><span class="label">My Achievements</span></a></li>

        @else
            <!-- MEMBER SECTION -->
            <h3>Member</h3>
            <li><a href="/member/history" class="@if(request()->is('member/history')) active @endif"><span class="icon"><i class="fas fa-history"></i></span><span class="label">Training History</span></a></li>
            <li><a href="/member/profile" class="@if(request()->is('member/profile')) active @endif"><span class="icon"><i class="fas fa-user"></i></span><span class="label">My Profile</span></a></li>
            <li><a href="/member/achievements" class="@if(request()->is('member/achievements')) active @endif"><span class="icon"><i class="fas fa-trophy"></i></span><span class="label">My Achievements</span></a></li>
        @endif
    </nav>

    <div class="sidebar-logout">
        <form action="/logout" method="POST" id="logoutForm">
            @csrf
            <button type="button" class="btn-logout" onclick="showLogoutConfirm()">
                <span class="icon"><i class="fas fa-sign-out-alt"></i></span><span class="label">Logout</span>
            </button>
        </form>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="logout-modal-overlay" id="logoutModalOverlay">
        <div class="logout-modal">
            <div class="logout-modal-header">
                <h2>Confirm Logout</h2>
                <button class="logout-modal-close" onclick="closeLogoutConfirm()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="logout-modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="logout-modal-footer">
                <button class="logout-btn-cancel" onclick="closeLogoutConfirm()">Cancel</button>
                <button class="logout-btn-confirm" onclick="confirmLogout()">Logout</button>
            </div>
        </div>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        updateMainContent();
    }

    function updateMainContent() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        if (mainContent) {
            if (sidebar.classList.contains('collapsed')) {
                mainContent.classList.add('sidebar-collapsed');
            } else {
                mainContent.classList.remove('sidebar-collapsed');
            }
        }
    }

    function showLogoutConfirm() {
        const modal = document.getElementById('logoutModalOverlay');
        modal.classList.add('active');
    }

    function closeLogoutConfirm() {
        const modal = document.getElementById('logoutModalOverlay');
        modal.classList.remove('active');
    }

    function confirmLogout() {
        const form = document.getElementById('logoutForm');
        form.submit();
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }
        updateMainContent();

        const modal = document.getElementById('logoutModalOverlay');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeLogoutConfirm();
                }
            });
        }
    });
</script>
