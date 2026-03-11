@extends('layouts.app')

@section('title', 'Training Logs')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-training-logs.css">
@endpush

@section('content')
    <div class="training-logs-management">
        <!-- Header with Create Button -->
        <div class="management-header">
            <div class="header-text">
                <h1>Training Logs</h1>
                <p>track and manage archer training sessions and progress</p>
            </div>
            <button class="btn-create-log" onclick="openCreateModal()">
                <i class="fas fa-plus"></i>
                New Training Log
            </button>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number">24</div>
                <div class="stat-label">Total Sessions</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">8</div>
                <div class="stat-label">Archers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">18</div>
                <div class="stat-label">This Month</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">82%</div>
                <div class="stat-label">Avg Score</div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter-section">
            <div class="search-box">
                <input type="text" id="logSearch" class="search-input" placeholder="Search by archer name or notes...">
            </div>
            <select id="distanceFilter" class="filter-select">
                <option value="">All Distances</option>
                <option value="18m">18 Meters</option>
                <option value="25m">25 Meters</option>
                <option value="30m">30 Meters</option>
                <option value="50m">50 Meters</option>
            </select>
        </div>

        <!-- Training Logs Table -->
        <div class="table-wrapper">
            <table class="logs-table" id="logsTable">
                <thead>
                    <tr>
                        <th>Archer Name</th>
                        <th>Date</th>
                        <th>Distance</th>
                        <th>Arrow Count</th>
                        <th>Total Score</th>
                        <th>Rating</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody">
                    <tr data-distance="18m">
                        <td>Juan Santos</td>
                        <td>03/10/2026</td>
                        <td>18m</td>
                        <td>12</td>
                        <td>108/120</td>
                        <td><span class="rating-badge excellent">⭐⭐⭐⭐⭐</span></td>
                        <td>Excellent form and accuracy</td>
                        <td>
                            <div class="action-menu">
                                <button class="btn-action-menu" onclick="toggleActionMenu(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="action-dropdown">
                                    <button class="action-item" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="action-item action-danger" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr data-distance="25m">
                        <td>Maria Cruz</td>
                        <td>03/10/2026</td>
                        <td>25m</td>
                        <td>12</td>
                        <td>98/120</td>
                        <td><span class="rating-badge good">⭐⭐⭐⭐</span></td>
                        <td>Steady performance, needs posture work</td>
                        <td>
                            <div class="action-menu">
                                <button class="btn-action-menu" onclick="toggleActionMenu(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="action-dropdown">
                                    <button class="action-item" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="action-item action-danger" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr data-distance="30m">
                        <td>Pedro Reyes</td>
                        <td>03/09/2026</td>
                        <td>30m</td>
                        <td>18</td>
                        <td>145/180</td>
                        <td><span class="rating-badge average">⭐⭐⭐</span></td>
                        <td>Fine-tuning grip and alignment</td>
                        <td>
                            <div class="action-menu">
                                <button class="btn-action-menu" onclick="toggleActionMenu(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="action-dropdown">
                                    <button class="action-item" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="action-item action-danger" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr data-distance="18m">
                        <td>Ana Rodriguez</td>
                        <td>03/08/2026</td>
                        <td>18m</td>
                        <td>12</td>
                        <td>102/120</td>
                        <td><span class="rating-badge good">⭐⭐⭐⭐</span></td>
                        <td>Great improvement, consistent</td>
                        <td>
                            <div class="action-menu">
                                <button class="btn-action-menu" onclick="toggleActionMenu(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="action-dropdown">
                                    <button class="action-item" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="action-item action-danger" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr data-distance="25m">
                        <td>Carlos Diaz</td>
                        <td>03/07/2026</td>
                        <td>25m</td>
                        <td>12</td>
                        <td>92/120</td>
                        <td><span class="rating-badge average">⭐⭐⭐</span></td>
                        <td>Needs more practice on consistency</td>
                        <td>
                            <div class="action-menu">
                                <button class="btn-action-menu" onclick="toggleActionMenu(this)"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="action-dropdown">
                                    <button class="action-item" onclick="openEditModal(this)"><i class="fas fa-edit"></i> Edit</button>
                                    <button class="action-item action-danger" onclick="openDeleteModal(this)"><i class="fas fa-trash"></i> Delete</button>
                                </div>
                            </div>
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

    <!-- Create Training Log Modal -->
    <div id="createLogModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Training Log</h2>
                <button class="modal-close" onclick="closeCreateModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Archer Name</label>
                    <input type="text" placeholder="Select archer" class="form-input">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Distance</label>
                        <select class="form-input">
                            <option>Select distance...</option>
                            <option>18 Meters</option>
                            <option>25 Meters</option>
                            <option>30 Meters</option>
                            <option>50 Meters</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Arrow Count</label>
                        <input type="number" placeholder="e.g., 12" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Total Score</label>
                        <input type="text" placeholder="e.g., 108/120" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label>Coach Rating</label>
                    <select class="form-input">
                        <option>Select rating...</option>
                        <option>⭐⭐⭐⭐⭐ Excellent</option>
                        <option>⭐⭐⭐⭐ Good</option>
                        <option>⭐⭐⭐ Average</option>
                        <option>⭐⭐ Fair</option>
                        <option>⭐ Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Technical Notes</label>
                    <input type="text" placeholder="Session notes and observations" class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeCreateModal()">Cancel</button>
                <button class="modal-btn-submit">Create Log</button>
            </div>
        </div>
    </div>

    <!-- Edit Training Log Modal -->
    <div id="editLogModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Training Log</h2>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Archer Name</label>
                    <input type="text" id="editArcher" placeholder="Select archer" class="form-input">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" id="editDate" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Distance</label>
                        <select id="editDistance" class="form-input">
                            <option>Select distance...</option>
                            <option>18 Meters</option>
                            <option>25 Meters</option>
                            <option>30 Meters</option>
                            <option>50 Meters</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Arrow Count</label>
                        <input type="number" id="editArrowCount" placeholder="e.g., 12" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Total Score</label>
                        <input type="text" id="editScore" placeholder="e.g., 108/120" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label>Coach Rating</label>
                    <select id="editRating" class="form-input">
                        <option selected disabled>Select rating...</option>
                        <option>⭐⭐⭐⭐⭐ Excellent</option>
                        <option>⭐⭐⭐⭐ Good</option>
                        <option>⭐⭐⭐ Average</option>
                        <option>⭐⭐ Fair</option>
                        <option>⭐ Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Technical Notes</label>
                    <input type="text" id="editNotes" placeholder="Session notes and observations" class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button class="modal-btn-submit">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Delete Training Log Modal -->
    <div id="deleteLogModal" class="modal">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h2>Delete Training Log</h2>
                <button class="modal-close" onclick="closeDeleteModal()">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the training log for <strong id="deleteArcher"></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="modal-btn-delete">Delete Log</button>
            </div>
        </div>
    </div>

    <script>
        // Pagination variables
        const itemsPerPage = 5;
        let currentPage = 1;
        let allRows = [];

        const logSearch = document.getElementById('logSearch');
        const distanceFilter = document.getElementById('distanceFilter');
        const rows = document.querySelectorAll('#logsTableBody tr');

        // Store all rows
        allRows = Array.from(rows);

        // Toggle action menu dropdown
        function toggleActionMenu(btn) {
            const menu = btn.closest('.action-menu');
            const dropdown = menu.querySelector('.action-dropdown');
            const isActive = dropdown.classList.toggle('active');

            // Close other menus
            document.querySelectorAll('.action-dropdown.active').forEach(other => {
                if (other !== dropdown) {
                    other.classList.remove('active');
                }
            });

            // Close menu when clicking outside
            if (isActive) {
                document.addEventListener('click', closeActionMenuOnClickOutside);
            } else {
                document.removeEventListener('click', closeActionMenuOnClickOutside);
            }
        }

        function closeActionMenuOnClickOutside(e) {
            if (!e.target.closest('.action-menu')) {
                document.querySelectorAll('.action-dropdown.active').forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
                document.removeEventListener('click', closeActionMenuOnClickOutside);
            }
        }

        function filterTable() {
            const searchTerm = logSearch.value.toLowerCase();
            const selectedDistance = distanceFilter.value.toLowerCase();

            rows.forEach(row => {
                const archer = row.cells[0].textContent.toLowerCase();
                const notes = row.cells[5].textContent.toLowerCase();
                const distance = row.getAttribute('data-distance').toLowerCase();

                const matchesSearch = archer.includes(searchTerm) || notes.includes(searchTerm);
                const matchesDistance = selectedDistance === '' || distance.includes(selectedDistance);

                row.style.display = matchesSearch && matchesDistance ? '' : 'none';
            });

            currentPage = 1;
            updatePagination();
        }

        function updatePagination() {
            const visibleRows = Array.from(document.querySelectorAll('#logsTableBody tr')).filter(row => row.style.display !== 'none');
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
            const visibleRows = Array.from(document.querySelectorAll('#logsTableBody tr')).filter(row => row.style.display !== 'none');
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

        logSearch.addEventListener('input', filterTable);
        distanceFilter.addEventListener('change', filterTable);

        updatePagination();

        // Modal functions
        function openCreateModal() {
            document.getElementById('createLogModal').classList.add('active');
        }

        function closeCreateModal() {
            document.getElementById('createLogModal').classList.remove('active');
        }

        function openEditModal(btn) {
            const row = btn.closest('tr');
            const archer = row.cells[0].textContent.trim();
            const date = row.cells[1].textContent.trim();
            const distance = row.cells[2].textContent.trim();
            const arrowCount = row.cells[3].textContent.trim();
            const score = row.cells[4].textContent.trim();
            const notes = row.cells[6].textContent.trim();

            document.getElementById('editArcher').value = archer;
            document.getElementById('editDate').value = formatDateForInput(date);
            document.getElementById('editDistance').value = distance + ' Meters';
            document.getElementById('editArrowCount').value = arrowCount;
            document.getElementById('editScore').value = score;
            document.getElementById('editNotes').value = notes;

            document.getElementById('editLogModal').classList.add('active');
        }

        function formatDateForInput(dateString) {
            const date = new Date(dateString);
            return date.toISOString().split('T')[0];
        }

        function closeEditModal() {
            document.getElementById('editLogModal').classList.remove('active');
        }

        function openDeleteModal(btn) {
            const row = btn.closest('tr');
            const archer = row.cells[0].textContent;
            document.getElementById('deleteArcher').textContent = archer;
            document.getElementById('deleteLogModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteLogModal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('createLogModal');
            const editModal = document.getElementById('editLogModal');
            const deleteModal = document.getElementById('deleteLogModal');

            if (e.target == createModal) createModal.classList.remove('active');
            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == deleteModal) deleteModal.classList.remove('active');
        });

        // Add loader functionality to form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Create Log button
            const createLogBtn = document.querySelector('#createLogModal .modal-btn-submit');
            if (createLogBtn) {
                createLogBtn.addEventListener('click', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Creating training log...");
                        // Simulate submission with 2 second delay
                        setTimeout(() => {
                            if (window.ArcheryLoader) ArcheryLoader.hide();
                            closeCreateModal();
                        }, 2000);
                    }
                });
            }

            // Edit Log button
            const editLogBtn = document.querySelector('#editLogModal .modal-btn-submit');
            if (editLogBtn) {
                editLogBtn.addEventListener('click', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Saving changes...");
                        // Simulate submission with 2 second delay
                        setTimeout(() => {
                            if (window.ArcheryLoader) ArcheryLoader.hide();
                            closeEditModal();
                        }, 2000);
                    }
                });
            }

            // Delete Log button
            const deleteLogBtn = document.querySelector('#deleteLogModal .modal-btn-delete');
            if (deleteLogBtn) {
                deleteLogBtn.addEventListener('click', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Deleting training log...");
                        // Simulate submission with 2 second delay
                        setTimeout(() => {
                            if (window.ArcheryLoader) ArcheryLoader.hide();
                            closeDeleteModal();
                        }, 2000);
                    }
                });
            }
        });
    </script>
@endsection