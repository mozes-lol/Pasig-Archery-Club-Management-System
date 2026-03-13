@extends('layouts.app')

@section('title', 'Archer List')
@section('page-title', 'Archers')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-archers.css">
<style>
    .archer-actions {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1.25rem;
    }

    .archer-actions .btn {
        padding: 0.45rem 0.9rem;
        font-size: 0.85rem;
    }

    .modal .form-group {
        margin-bottom: 1rem;
    }
</style>
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
            @foreach ($archers as $archer)
                <div class="archer-card"
                    data-archer-id="{{ $archer->archer_id }}"
                    data-archer-name="{{ $archer->first_name }} {{ $archer->last_name }}"
                    data-experience-level="{{ $archer->experience_level ?? '' }}"
                    data-ranking="{{ $archer->ranking ?? '' }}"
                >
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
                        <h3 class="archer-name">{{ $archer->first_name }} {{ $archer->last_name }}</h3>
                        <p class="archer-rank">{{ $archer->experience_level ?? 'Unspecified' }}</p>
                        <div class="archer-status">
                            <span class="status-indicator active"></span>
                            <span class="status-text">Active</span>
                        </div>
                        <div class="archer-meta">
                            <div class="meta-item">
                                <i class="fas fa-medal"></i>
                                <span>{{ $archer->ranking ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $archer->join_date ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="archer-actions">
                            <button class="btn btn-primary" type="button" onclick="openEditArcherModal(this)">Edit Level/Rank</button>
                            <button class="btn btn-success" type="button" onclick="openAwardModal(this)">Assign Achievement</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Edit Archer Modal -->
    <div id="editArcherModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Archer</h2>
                <button class="modal-close" onclick="closeEditArcherModal()">×</button>
            </div>
            <form method="POST" action="{{ route('coach.archers.update', ['id' => '__ID__']) }}" id="editArcherForm" data-action="{{ route('coach.archers.update', ['id' => '__ID__']) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="archer_id" id="editArcherId">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Archer</label>
                        <input type="text" id="editArcherName" class="form-input" readonly>
                    </div>
                    <div class="form-group">
                        <label>Experience Level</label>
                        <input type="text" id="editExperienceLevel" name="experience_level" class="form-input" placeholder="e.g., Beginner, Intermediate">
                    </div>
                    <div class="form-group">
                        <label>Ranking</label>
                        <input type="text" id="editRanking" name="ranking" class="form-input" placeholder="e.g., A, B, C or 1200">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeEditArcherModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Award Achievement Modal -->
    <div id="awardAchievementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Assign Achievement</h2>
                <button class="modal-close" onclick="closeAwardModal()">×</button>
            </div>
            <form method="POST" action="{{ route('coach.archers.achievements.award', ['id' => '__ID__']) }}" id="awardAchievementForm" data-action="{{ route('coach.archers.achievements.award', ['id' => '__ID__']) }}">
                @csrf
                <input type="hidden" name="archer_id" id="awardArcherId">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Archer</label>
                        <input type="text" id="awardArcherName" class="form-input" readonly>
                    </div>
                    <div class="form-group">
                        <label>Achievement</label>
                        <select name="achievement_id" class="form-input" required>
                            <option value="">Select achievement...</option>
                            @foreach ($achievements as $achievement)
                                <option value="{{ $achievement->achievement_id }}">{{ $achievement->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Awarded</label>
                        <input type="date" name="date_awarded" class="form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeAwardModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Assign Achievement</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditArcherModal(btn) {
            const card = btn.closest('.archer-card');
            const id = card.dataset.archerId;
            const name = card.dataset.archerName;
            const experience = card.dataset.experienceLevel || '';
            const ranking = card.dataset.ranking || '';

            document.getElementById('editArcherId').value = id;
            document.getElementById('editArcherName').value = name;
            document.getElementById('editExperienceLevel').value = experience;
            document.getElementById('editRanking').value = ranking;

            const form = document.getElementById('editArcherForm');
            form.action = form.dataset.action.replace('__ID__', id);

            document.getElementById('editArcherModal').classList.add('active');
        }

        function closeEditArcherModal() {
            document.getElementById('editArcherModal').classList.remove('active');
        }

        function openAwardModal(btn) {
            const card = btn.closest('.archer-card');
            const id = card.dataset.archerId;
            const name = card.dataset.archerName;

            document.getElementById('awardArcherId').value = id;
            document.getElementById('awardArcherName').value = name;

            const form = document.getElementById('awardAchievementForm');
            form.action = form.dataset.action.replace('__ID__', id);

            document.getElementById('awardAchievementModal').classList.add('active');
        }

        function closeAwardModal() {
            document.getElementById('awardAchievementModal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const editModal = document.getElementById('editArcherModal');
            const awardModal = document.getElementById('awardAchievementModal');

            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == awardModal) awardModal.classList.remove('active');
        });
    </script>
@endsection
