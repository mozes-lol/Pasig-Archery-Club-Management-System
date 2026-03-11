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
                <div class="stat-number">8</div>
                <div class="stat-label">Total Achievements</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">12</div>
                <div class="stat-label">Most Awarded</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">2</div>
                <div class="stat-label">Pending Review</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">6</div>
                <div class="stat-label">Active Achievements</div>
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
                    <tr data-criteria="accuracy">
                        <td>🏆</td>
                        <td>Marksman</td>
                        <td>Achieved 90% accuracy</td>
                        <td><span class="criteria-badge accuracy">Accuracy</span></td>
                        <td>90%</td>
                        <td>
                            <button class="btn-edit" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn-delete" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    <tr data-criteria="sessions">
                        <td>🎯</td>
                        <td>Sharpshooter</td>
                        <td>Completed 20 training sessions</td>
                        <td><span class="criteria-badge sessions">Sessions</span></td>
                        <td>20</td>
                        <td>
                            <button class="btn-edit" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn-delete" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    <tr data-criteria="hours">
                        <td>⭐</td>
                        <td>Dedicated Archer</td>
                        <td>40+ hours of training</td>
                        <td><span class="criteria-badge hours">Hours</span></td>
                        <td>40</td>
                        <td>
                            <button class="btn-edit" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn-delete" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    <tr data-criteria="consecutive">
                        <td>🔥</td>
                        <td>On Fire</td>
                        <td>5 consecutive perfect sessions</td>
                        <td><span class="criteria-badge consecutive">Consecutive</span></td>
                        <td>5</td>
                        <td>
                            <button class="btn-edit" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn-delete" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                    <tr data-criteria="sessions">
                        <td>🏅</td>
                        <td>Team Player</td>
                        <td>Mentored 3 new members</td>
                        <td><span class="criteria-badge sessions">Sessions</span></td>
                        <td>3</td>
                        <td>
                            <button class="btn-edit" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn-delete" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <button class="pagination-btn" id="prevBtn" onclick="previousPage()">← Previous</button>
            <div class="pagination-numbers" id="paginationNumbers"></div>
            <button class="pagination-btn" id="nextBtn" onclick="nextPage()">Next →</button>
        </div>
    </div>

    <!-- Create Achievement Modal -->
    <div id="createAchievementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Achievement</h2>
                <button class="modal-close" onclick="closeCreateModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Badge Icon</label>
                    <div class="icon-selector" id="createIconSelector">
                        <button type="button" class="icon-btn" data-icon="trophy" onclick="selectIcon(this, 'createIconSelector')" title="Trophy"><i class="fas fa-trophy"></i></button>
                        <button type="button" class="icon-btn" data-icon="star" onclick="selectIcon(this, 'createIconSelector')" title="Star"><i class="fas fa-star"></i></button>
                        <button type="button" class="icon-btn" data-icon="medal" onclick="selectIcon(this, 'createIconSelector')" title="Medal"><i class="fas fa-medal"></i></button>
                        <button type="button" class="icon-btn" data-icon="award" onclick="selectIcon(this, 'createIconSelector')" title="Award"><i class="fas fa-award"></i></button>
                        <button type="button" class="icon-btn" data-icon="target" onclick="selectIcon(this, 'createIconSelector')" title="Target"><i class="fas fa-bullseye"></i></button>
                        <button type="button" class="icon-btn" data-icon="crown" onclick="selectIcon(this, 'createIconSelector')" title="Crown"><i class="fas fa-crown"></i></button>
                        <button type="button" class="icon-btn" data-icon="gem" onclick="selectIcon(this, 'createIconSelector')" title="Gem"><i class="fas fa-gem"></i></button>
                        <button type="button" class="icon-btn" data-icon="fire" onclick="selectIcon(this, 'createIconSelector')" title="Fire"><i class="fas fa-fire"></i></button>
                    </div>
                    <input type="hidden" id="selectedIcon" value="">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" placeholder="Achievement title" class="form-input">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" placeholder="Achievement description" class="form-input">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Criteria Type</label>
                        <select class="form-input">
                            <option>Select criteria type...</option>
                            <option>Accuracy</option>
                            <option>Sessions</option>
                            <option>Hours</option>
                            <option>Consecutive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Criteria Value</label>
                        <input type="number" placeholder="e.g., 90" class="form-input">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeCreateModal()">Cancel</button>
                <button class="modal-btn-submit">Create Achievement</button>
            </div>
        </div>
    </div>

    <!-- Edit Achievement Modal -->
    <div id="editAchievementModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Achievement</h2>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Badge Icon</label>
                    <div class="icon-selector" id="editIconSelector">
                        <button type="button" class="icon-btn" data-icon="trophy" onclick="selectIcon(this, 'editIconSelector')" title="Trophy"><i class="fas fa-trophy"></i></button>
                        <button type="button" class="icon-btn" data-icon="star" onclick="selectIcon(this, 'editIconSelector')" title="Star"><i class="fas fa-star"></i></button>
                        <button type="button" class="icon-btn" data-icon="medal" onclick="selectIcon(this, 'editIconSelector')" title="Medal"><i class="fas fa-medal"></i></button>
                        <button type="button" class="icon-btn" data-icon="award" onclick="selectIcon(this, 'editIconSelector')" title="Award"><i class="fas fa-award"></i></button>
                        <button type="button" class="icon-btn" data-icon="target" onclick="selectIcon(this, 'editIconSelector')" title="Target"><i class="fas fa-bullseye"></i></button>
                        <button type="button" class="icon-btn" data-icon="crown" onclick="selectIcon(this, 'editIconSelector')" title="Crown"><i class="fas fa-crown"></i></button>
                        <button type="button" class="icon-btn" data-icon="gem" onclick="selectIcon(this, 'editIconSelector')" title="Gem"><i class="fas fa-gem"></i></button>
                        <button type="button" class="icon-btn" data-icon="fire" onclick="selectIcon(this, 'editIconSelector')" title="Fire"><i class="fas fa-fire"></i></button>
                    </div>
                    <input type="hidden" id="selectedEditIcon" value="">
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="editTitle" placeholder="Achievement title" class="form-input">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" id="editDescription" placeholder="Achievement description" class="form-input">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Criteria Type</label>
                        <select id="editCriteria" class="form-input">
                            <option>Select criteria type...</option>
                            <option>Accuracy</option>
                            <option>Sessions</option>
                            <option>Hours</option>
                            <option>Consecutive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Criteria Value</label>
                        <input type="number" id="editValue" placeholder="e.g., 90" class="form-input">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button class="modal-btn-submit">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Delete Achievement Modal -->
    <div id="deleteAchievementModal" class="modal">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h2>Delete Achievement</h2>
                <button class="modal-close" onclick="closeDeleteModal()">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteTitle"></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="modal-btn-delete">Delete Achievement</button>
            </div>
        </div>
    </div>

    <script>
        // Pagination variables
        const itemsPerPage = 5;
        let currentPage = 1;
        let allRows = [];

        const achievementSearch = document.getElementById('achievementSearch');
        const criteriaFilter = document.getElementById('criteriaFilter');
        const rows = document.querySelectorAll('#achievementsTableBody tr');

        // Store all rows
        allRows = Array.from(rows);

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

        // Modal functions
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
        }

        function openEditModal(btn) {
            const row = btn.closest('tr');
            const icon = row.cells[0].textContent;
            const title = row.cells[1].textContent;
            const description = row.cells[2].textContent;
            const criteria = row.cells[3].textContent.trim();
            const value = row.cells[4].textContent;

            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editCriteria').value = criteria.charAt(0).toUpperCase() + criteria.slice(1);
            document.getElementById('editValue').value = value;

            document.getElementById('editAchievementModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editAchievementModal').classList.remove('active');
        }

        function openDeleteModal(btn) {
            const row = btn.closest('tr');
            const title = row.cells[1].textContent;
            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('deleteAchievementModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteAchievementModal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('createAchievementModal');
            const editModal = document.getElementById('editAchievementModal');
            const deleteModal = document.getElementById('deleteAchievementModal');

            if (e.target == createModal) createModal.classList.remove('active');
            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == deleteModal) deleteModal.classList.remove('active');
        });
    </script>
@endsection