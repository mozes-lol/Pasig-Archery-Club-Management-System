@extends('layouts.app')

@section('title', 'Achievements Management')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/admin-achievements.css">
@endpush

@section('content')
    <div class="achievements-management">
        <!-- Header with Create Button -->
        <div class="management-header">
            <div class="header-text">
                <h1>Achievements Management</h1>
                <p>create and manage achievement badges and criteria</p>
            </div>
            <button class="btn-create-achievement" onclick="openCreateModal()">
                <i class="fas fa-plus"></i>
                Create Achievement
            </button>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number">{{ $achievements->count() }}</div>
                <div class="stat-label">Total Achievements</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $achievements->where('criteria_type','accuracy')->count() }}</div>
                <div class="stat-label">Accuracy Type</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $achievements->where('criteria_type','sessions')->count() }}</div>
                <div class="stat-label">Session Type</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $achievements->where('criteria_type','hours')->count() }}</div>
                <div class="stat-label">Hours Type</div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter-section">
            <div class="search-box">
                <input type="text" id="achievementSearch" class="search-input" placeholder="Search by title or description...">
            </div>
            <select id="criteriaFilter" class="filter-select">
                <option value="">All Criteria Types</option>
                <option value="accuracy">Accuracy</option>
                <option value="sessions">Sessions</option>
                <option value="hours">Hours</option>
                <option value="consecutive">Consecutive</option>
            </select>
        </div>

        <!-- Achievements Table -->
        <div class="table-wrapper">
            <table class="achievements-table" id="achievementsTable">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Criteria Type</th>
                        <th>Criteria Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="achievementsTableBody">
                    @foreach ($achievements as $a)
                        <tr data-criteria="{{ $a->criteria_type }}">
                            <td>{{ $a->badge_icon }}</td>
                            <td>{{ $a->title }}</td>
                            <td>{{ $a->description }}</td>
                            <td><span class="criteria-badge {{ $a->criteria_type }}">{{ $a->criteria_type }}</span></td>
                            <td>{{ $a->criteria_value }}</td>
                            <td>
                                <button class="btn-edit" onclick="openEditModal(this)" data-id="{{ $a->achievement_id }}"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn-delete" onclick="openDeleteModal(this)" data-id="{{ $a->achievement_id }}"><i class="fas fa-trash"></i> Delete</button>
                                <button class="btn-edit" onclick="openAwardModal(this)" data-id="{{ $a->achievement_id }}"><i class="fas fa-award"></i> Award</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination" role="navigation" aria-label="Pagination">
            <button class="pagination-btn" id="prevBtn" onclick="previousPage()" aria-label="Previous page">← Previous</button>
            <div class="pagination-numbers" id="paginationNumbers" aria-label="Page numbers"></div>
            <button class="pagination-btn" id="nextBtn" onclick="nextPage()" aria-label="Next page">Next →</button>
        </div>
    </div>

    <!-- Create Achievement Modal -->
    <div id="createAchievementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Achievement</h2>
                <button class="modal-close" onclick="closeCreateModal()">×</button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.create') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Badge Icon</label>
                        <div class="icon-selector" id="createIconSelector">
                            <button type="button" class="icon-btn" data-icon="🏆" onclick="selectIcon(this, 'createIconSelector')" title="Trophy">🏆</button>
                            <button type="button" class="icon-btn" data-icon="⭐" onclick="selectIcon(this, 'createIconSelector')" title="Star">⭐</button>
                            <button type="button" class="icon-btn" data-icon="🎯" onclick="selectIcon(this, 'createIconSelector')" title="Target">🎯</button>
                            <button type="button" class="icon-btn" data-icon="🔥" onclick="selectIcon(this, 'createIconSelector')" title="Fire">🔥</button>
                            <button type="button" class="icon-btn" data-icon="🏅" onclick="selectIcon(this, 'createIconSelector')" title="Medal">🏅</button>
                            <button type="button" class="icon-btn" data-icon="💎" onclick="selectIcon(this, 'createIconSelector')" title="Gem">💎</button>
                        </div>
                        <input type="hidden" id="selectedIcon" name="badge_icon" value="">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" placeholder="Achievement title" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" placeholder="Achievement description" class="form-input">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Criteria Type</label>
                            <select name="criteria_type" class="form-input">
                                <option value="">Select criteria type...</option>
                                <option value="accuracy">Accuracy</option>
                                <option value="sessions">Sessions</option>
                                <option value="hours">Hours</option>
                                <option value="consecutive">Consecutive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Criteria Value</label>
                            <input type="number" name="criteria_value" placeholder="e.g., 90" class="form-input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeCreateModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Create Achievement</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Achievement Modal -->
    <div id="editAchievementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Achievement</h2>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.update', ['id' => '__ID__']) }}" id="editAchievementForm" data-action="{{ route('admin.achievements.update', ['id' => '__ID__']) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="editAchievementId">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Badge Icon</label>
                        <div class="icon-selector" id="editIconSelector">
                            <button type="button" class="icon-btn" data-icon="🏆" onclick="selectIcon(this, 'editIconSelector')" title="Trophy">🏆</button>
                            <button type="button" class="icon-btn" data-icon="⭐" onclick="selectIcon(this, 'editIconSelector')" title="Star">⭐</button>
                            <button type="button" class="icon-btn" data-icon="🎯" onclick="selectIcon(this, 'editIconSelector')" title="Target">🎯</button>
                            <button type="button" class="icon-btn" data-icon="🔥" onclick="selectIcon(this, 'editIconSelector')" title="Fire">🔥</button>
                            <button type="button" class="icon-btn" data-icon="🏅" onclick="selectIcon(this, 'editIconSelector')" title="Medal">🏅</button>
                            <button type="button" class="icon-btn" data-icon="💎" onclick="selectIcon(this, 'editIconSelector')" title="Gem">💎</button>
                        </div>
                        <input type="hidden" id="selectedEditIcon" name="badge_icon" value="">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" id="editTitle" name="title" placeholder="Achievement title" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" id="editDescription" name="description" placeholder="Achievement description" class="form-input">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Criteria Type</label>
                            <select id="editCriteria" name="criteria_type" class="form-input">
                                <option value="">Select criteria type...</option>
                                <option value="accuracy">Accuracy</option>
                                <option value="sessions">Sessions</option>
                                <option value="hours">Hours</option>
                                <option value="consecutive">Consecutive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Criteria Value</label>
                            <input type="number" id="editValue" name="criteria_value" placeholder="e.g., 90" class="form-input">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Achievement Modal -->
    <div id="deleteAchievementModal" class="modal">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h2>Delete Achievement</h2>
                <button class="modal-close" onclick="closeDeleteModal()">×</button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.delete', ['id' => '__ID__']) }}" id="deleteAchievementForm" data-action="{{ route('admin.achievements.delete', ['id' => '__ID__']) }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="deleteAchievementId">
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteTitle"></strong>? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="modal-btn-delete">Delete Achievement</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Award Achievement Modal -->
    <div id="awardAchievementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Award Achievement</h2>
                <button class="modal-close" onclick="closeAwardModal()">×</button>
            </div>
            <form method="POST" action="{{ route('admin.achievements.award') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="awardAchievementId" name="achievement_id">
                    <div class="form-group">
                        <label>Archer</label>
                        <select name="archer_id" class="form-input" required>
                            <option value="">Select archer...</option>
                            @foreach ($archers as $archer)
                                <option value="{{ $archer->archer_id }}">{{ $archer->first_name }} {{ $archer->last_name }}</option>
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
                    <button type="submit" class="modal-btn-submit">Award</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const itemsPerPage = 5;
        let currentPage = 1;

        const achievementSearch = document.getElementById('achievementSearch');
        const criteriaFilter = document.getElementById('criteriaFilter');
        const rows = document.querySelectorAll('#achievementsTableBody tr');

        function filterTable() {
            const searchTerm = achievementSearch.value.toLowerCase();
            const selectedCriteria = criteriaFilter.value.toLowerCase();

            rows.forEach(row => {
                const title = row.cells[1].textContent.toLowerCase();
                const description = row.cells[2].textContent.toLowerCase();
                const criteria = row.getAttribute('data-criteria').toLowerCase();

                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesCriteria = selectedCriteria === '' || criteria.includes(selectedCriteria);

                row.style.display = matchesSearch && matchesCriteria ? '' : 'none';
            });

            currentPage = 1;
            updatePagination();
        }

        function updatePagination() {
            const visibleRows = Array.from(document.querySelectorAll('#achievementsTableBody tr')).filter(row => row.style.display !== 'none');
            const totalPages = Math.ceil(visibleRows.length / itemsPerPage);

            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;

            const paginationNumbers = document.getElementById('paginationNumbers');
            paginationNumbers.innerHTML = '';

            const maxVisible = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);

            if (endPage - startPage + 1 < maxVisible) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            if (startPage > 1) {
                const btn = document.createElement('button');
                btn.className = 'pagination-number';
                btn.textContent = '1';
                btn.onclick = () => goToPage(1);
                paginationNumbers.appendChild(btn);

                if (startPage > 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'pagination-ellipsis';
                    ellipsis.textContent = '...';
                    paginationNumbers.appendChild(ellipsis);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                const btn = document.createElement('button');
                btn.className = `pagination-number ${i === currentPage ? 'active' : ''}`;
                btn.textContent = i;
                btn.onclick = () => goToPage(i);
                paginationNumbers.appendChild(btn);
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'pagination-ellipsis';
                    ellipsis.textContent = '...';
                    paginationNumbers.appendChild(ellipsis);
                }

                const btn = document.createElement('button');
                btn.className = 'pagination-number';
                btn.textContent = totalPages;
                btn.onclick = () => goToPage(totalPages);
                paginationNumbers.appendChild(btn);
            }

            visibleRows.forEach((row, index) => {
                const pageStart = (currentPage - 1) * itemsPerPage;
                const pageEnd = pageStart + itemsPerPage;
                row.style.display = index >= pageStart && index < pageEnd ? '' : 'none';
            });
        }

        function nextPage() {
            const visibleRows = Array.from(document.querySelectorAll('#achievementsTableBody tr')).filter(row => row.style.display !== 'none');
            const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        }

        function goToPage(page) {
            currentPage = page;
            updatePagination();
        }

        achievementSearch.addEventListener('input', filterTable);
        criteriaFilter.addEventListener('change', filterTable);

        updatePagination();

        function openCreateModal() {
            document.getElementById('createAchievementModal').classList.add('active');
        }

        function closeCreateModal() {
            document.getElementById('createAchievementModal').classList.remove('active');
        }

        function selectIcon(button, selectorId) {
            const selector = document.getElementById(selectorId);
            const buttons = selector.querySelectorAll('.icon-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            if (selectorId === 'createIconSelector') {
                document.getElementById('selectedIcon').value = button.dataset.icon;
            } else {
                document.getElementById('selectedEditIcon').value = button.dataset.icon;
            }
        }

        function openEditModal(btn) {
            const row = btn.closest('tr');
            const icon = row.cells[0].textContent.trim();
            const title = row.cells[1].textContent.trim();
            const description = row.cells[2].textContent.trim();
            const criteria = row.getAttribute('data-criteria');
            const value = row.cells[4].textContent.trim();
            const id = btn.getAttribute('data-id');

            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editCriteria').value = criteria;
            document.getElementById('editValue').value = value;
            document.getElementById('selectedEditIcon').value = icon;
            document.getElementById('editAchievementId').value = id;

            const editForm = document.getElementById('editAchievementForm');
            editForm.action = editForm.dataset.action.replace('__ID__', id);

            document.getElementById('editAchievementModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editAchievementModal').classList.remove('active');
        }

        function openDeleteModal(btn) {
            const row = btn.closest('tr');
            const title = row.cells[1].textContent;
            const id = btn.getAttribute('data-id');

            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('deleteAchievementId').value = id;

            const deleteForm = document.getElementById('deleteAchievementForm');
            deleteForm.action = deleteForm.dataset.action.replace('__ID__', id);

            document.getElementById('deleteAchievementModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteAchievementModal').classList.remove('active');
        }

        function openAwardModal(btn) {
            const id = btn.getAttribute('data-id');
            document.getElementById('awardAchievementId').value = id;
            document.getElementById('awardAchievementModal').classList.add('active');
        }

        function closeAwardModal() {
            document.getElementById('awardAchievementModal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('createAchievementModal');
            const editModal = document.getElementById('editAchievementModal');
            const deleteModal = document.getElementById('deleteAchievementModal');
            const awardModal = document.getElementById('awardAchievementModal');

            if (e.target == createModal) createModal.classList.remove('active');
            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == deleteModal) deleteModal.classList.remove('active');
            if (e.target == awardModal) awardModal.classList.remove('active');
        });
    </script>
@endsection
