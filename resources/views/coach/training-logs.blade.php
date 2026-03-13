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
                <div class="stat-number">{{ $stats['total_sessions'] ?? 0 }}</div>
                <div class="stat-label">Total Sessions</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['archers'] ?? 0 }}</div>
                <div class="stat-label">Archers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['this_month'] ?? 0 }}</div>
                <div class="stat-label">This Month</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['avg_score'] ?? 0 }}</div>
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
                <option value="18">18 Meters</option>
                <option value="25">25 Meters</option>
                <option value="30">30 Meters</option>
                <option value="50">50 Meters</option>
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
                    @foreach ($trainingLogs as $log)
                        <tr data-distance="{{ $log->distance }}">
                            <td>{{ $log->archer_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->session_date)->format('m/d/Y') }}</td>
                            <td>{{ $log->distance }}</td>
                            <td>{{ $log->arrow_count }}</td>
                            <td>{{ $log->total_score }}</td>
                            <td>{{ $log->coach_rating }}</td>
                            <td>{{ $log->technical_notes }}</td>
                            <td>
                                <div class="action-menu">
                                    <button class="btn-action-menu" onclick="toggleActionMenu(this)"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="action-dropdown">
                                        <button class="action-item" onclick="openEditModal(this)" data-id="{{ $log->log_id }}"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="action-item action-danger" onclick="openDeleteModal(this)" data-id="{{ $log->log_id }}"><i class="fas fa-trash"></i> Delete</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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
            <form method="POST" action="{{ route('coach.training.store') }}" data-no-top-loader>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Archer</label>
                        <select name="archer_id" class="form-input" required>
                            <option value="">Select archer...</option>
                            @foreach ($archers as $archer)
                                <option value="{{ $archer->archer_id }}">{{ $archer->first_name }} {{ $archer->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="session_date" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>Distance (m)</label>
                            <input type="number" name="distance" class="form-input" min="1" max="2147483647">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Arrow Count</label>
                            <input type="number" name="arrow_count" class="form-input" min="1" max="2147483647">
                        </div>
                        <div class="form-group">
                            <label>Total Score</label>
                            <input type="number" name="total_score" class="form-input" min="0" max="2147483647">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Coach Rating (1-5)</label>
                        <input type="number" name="coach_rating" min="1" max="5" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Technical Notes</label>
                        <input type="text" name="technical_notes" class="form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeCreateModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Create Log</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Training Log Modal -->
    <div id="editLogModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Training Log</h2>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            <form method="POST" action="{{ route('coach.training.update', ['id' => '__ID__']) }}" id="editLogForm" data-action="{{ route('coach.training.update', ['id' => '__ID__']) }}" data-no-top-loader>
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="editLogId">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Archer</label>
                        <input type="text" id="editArcher" class="form-input" readonly>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" id="editDate" name="session_date" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>Distance (m)</label>
                            <input type="number" id="editDistance" name="distance" class="form-input" min="1" max="2147483647">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Arrow Count</label>
                            <input type="number" id="editArrowCount" name="arrow_count" class="form-input" min="1" max="2147483647">
                        </div>
                        <div class="form-group">
                            <label>Total Score</label>
                            <input type="number" id="editScore" name="total_score" class="form-input" min="0" max="2147483647">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Coach Rating (1-5)</label>
                        <input type="number" id="editRating" name="coach_rating" min="1" max="5" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Technical Notes</label>
                        <input type="text" id="editNotes" name="technical_notes" class="form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Training Log Modal -->
    <div id="deleteLogModal" class="modal">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h2>Delete Training Log</h2>
                <button class="modal-close" onclick="closeDeleteModal()">×</button>
            </div>
            <form method="POST" action="{{ route('coach.training.delete', ['id' => '__ID__']) }}" id="deleteLogForm" data-action="{{ route('coach.training.delete', ['id' => '__ID__']) }}" data-no-top-loader>
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="deleteLogId">
                <div class="modal-body">
                    <p>Are you sure you want to delete the training log for <strong id="deleteArcher"></strong>? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="modal-btn-delete">Delete Log</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const itemsPerPage = 5;
        let currentPage = 1;

        const logSearch = document.getElementById('logSearch');
        const distanceFilter = document.getElementById('distanceFilter');
        const rows = document.querySelectorAll('#logsTableBody tr');

        function filterTable() {
            const searchTerm = logSearch.value.toLowerCase();
            const selectedDistance = distanceFilter.value.toLowerCase();

            rows.forEach(row => {
                const archer = row.cells[0].textContent.toLowerCase();
                const notes = row.cells[6].textContent.toLowerCase();
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
            const rating = row.cells[5].textContent.trim();
            const notes = row.cells[6].textContent.trim();
            const id = btn.getAttribute('data-id');

            document.getElementById('editArcher').value = archer;
            document.getElementById('editDate').value = formatDateForInput(date);
            document.getElementById('editDistance').value = distance;
            document.getElementById('editArrowCount').value = arrowCount;
            document.getElementById('editScore').value = score;
            document.getElementById('editRating').value = rating;
            document.getElementById('editNotes').value = notes;
            document.getElementById('editLogId').value = id;

            const editForm = document.getElementById('editLogForm');
            editForm.action = editForm.dataset.action.replace('__ID__', id);

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
            const id = btn.getAttribute('data-id');

            document.getElementById('deleteArcher').textContent = archer;
            document.getElementById('deleteLogId').value = id;

            const deleteForm = document.getElementById('deleteLogForm');
            deleteForm.action = deleteForm.dataset.action.replace('__ID__', id);

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

        document.addEventListener('DOMContentLoaded', function() {
            const createForm = document.querySelector('#createLogModal form');
            if (createForm) {
                createForm.addEventListener('submit', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Creating training log...");
                    }
                });
            }

            const editForm = document.getElementById('editLogForm');
            if (editForm) {
                editForm.addEventListener('submit', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Saving changes...");
                    }
                });
            }

            const deleteForm = document.getElementById('deleteLogForm');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Deleting training log...");
                    }
                });
            }
        });
    </script>
@endsection
