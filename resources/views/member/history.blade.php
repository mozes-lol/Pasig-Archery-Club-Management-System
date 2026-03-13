@extends('layouts.app')

@section('title', 'Training History')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-training-logs.css">
@endpush

@section('content')
    <div class="training-logs-management">
        <!-- Header -->
        <div class="management-header">
            <div class="header-text">
                <h1>Training History</h1>
                <p>View your personal training sessions and progress</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <div class="filter-group">
                <label for="logSearch">Search</label>
                <input type="text" id="logSearch" class="filter-input" placeholder="Search by date or notes...">
            </div>
            <div class="filter-group">
                <label for="distanceFilter">Distance</label>
                <select id="distanceFilter" class="filter-select">
                    <option value="">All Distances</option>
                    <option value="18">18m</option>
                    <option value="25">25m</option>
                    <option value="30">30m</option>
                    <option value="40">40m</option>
                    <option value="50">50m</option>
                    <option value="60">60m</option>
                    <option value="70">70m</option>
                </select>
            </div>
        </div>

        <div class="card-body">
            <table class="table" id="memberLogsTable">
                <thead>
                    <tr>
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
                    @forelse ($logs as $log)
                        <tr data-id="{{ $log->log_id }}" data-distance="{{ $log->distance }}">
                            <td>{{ \Carbon\Carbon::parse($log->session_date)->format('F d, Y') }}</td>
                            <td><span class="badge badge-primary">{{ $log->distance }}m</span></td>
                            <td>{{ $log->arrow_count ?? 'N/A' }}</td>
                            <td>{{ $log->total_score }}/{{ $log->max_score ?? '120' }}</td>
                            <td>
                                @if($log->coach_rating >= 5)
                                    <span class="rating-badge excellent">⭐⭐⭐⭐⭐</span>
                                @elseif($log->coach_rating >= 4)
                                    <span class="rating-badge good">⭐⭐⭐⭐</span>
                                @elseif($log->coach_rating >= 3)
                                    <span class="rating-badge average">⭐⭐⭐</span>
                                @else
                                    <span class="rating-badge poor">⭐⭐</span>
                                @endif
                            </td>
                            <td>{{ $log->technical_notes ?? 'No notes' }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="#" class="btn btn-sm btn-primary" onclick="openEditLogModal(this)">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger" onclick="openDeleteLogModal(this)">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No training logs found. Add your first training session!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <button class="pagination-btn" id="prevBtn" onclick="previousPage()">&larr; Previous</button>
            <div class="pagination-numbers" id="paginationNumbers"></div>
            <button class="pagination-btn" id="nextBtn" onclick="nextPage()">Next &rarr;</button>
        </div>

        <div style="margin-top: 2rem;">
            <a href="/member/create-log" class="btn btn-success">➕ Add New Training Log</a>
        </div>
    </div>

    <!-- Edit Log Modal -->
    <div id="editMemberLogModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Training Log</h2>
                <button class="modal-close" onclick="closeEditLogModal()">×</button>
            </div>
            <form method="POST" action="{{ route('member.training-logs.update', ['id' => '__ID__']) }}" id="editMemberLogForm" data-action="{{ route('member.training-logs.update', ['id' => '__ID__']) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="editMemberLogId">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" id="editMemberDate" name="session_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Distance (m)</label>
                        <input type="number" id="editMemberDistance" name="distance" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Arrow Count</label>
                        <input type="number" id="editMemberArrowCount" name="arrow_count" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Total Score</label>
                        <input type="number" id="editMemberScore" name="total_score" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Coach Rating (1-5)</label>
                        <input type="number" id="editMemberRating" name="coach_rating" min="1" max="5" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Technical Notes</label>
                        <input type="text" id="editMemberNotes" name="technical_notes" class="form-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeEditLogModal()">Cancel</button>
                    <button type="submit" class="modal-btn-submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Log Modal -->
    <div id="deleteMemberLogModal" class="modal">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h2>Delete Training Log</h2>
                <button class="modal-close" onclick="closeDeleteLogModal()">×</button>
            </div>
            <form method="POST" action="{{ route('member.training-logs.delete', ['id' => '__ID__']) }}" id="deleteMemberLogForm" data-action="{{ route('member.training-logs.delete', ['id' => '__ID__']) }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="deleteMemberLogId">
                <div class="modal-body">
                    <p>Are you sure you want to delete this training log? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" onclick="closeDeleteLogModal()">Cancel</button>
                    <button type="submit" class="modal-btn-delete">Delete Log</button>
                </div>
            </form>
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

        function filterTable() {
            const searchTerm = logSearch.value.toLowerCase();
            const selectedDistance = distanceFilter.value.toLowerCase();

            allRows.forEach(row => {
                const dateText = row.cells[0].textContent.toLowerCase();
                const notes = row.cells[5].textContent.toLowerCase();
                const distance = row.getAttribute('data-distance') || '';

                const matchesSearch = dateText.includes(searchTerm) || notes.includes(searchTerm);
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

            if (totalPages === 0) return;

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

        // Edit Modal Functions
        function openEditLogModal(btn) {
            const row = btn.closest('tr');
            const id = row.getAttribute('data-id');
            const date = row.cells[0].textContent.trim();
            const distance = row.cells[1].textContent.replace('m','').trim();
            const arrowCount = row.cells[2].textContent.trim();
            const score = row.cells[3].textContent.split('/')[0].trim();
            const notes = row.cells[5].textContent.trim();

            document.getElementById('editMemberLogId').value = id;
            document.getElementById('editMemberDate').value = new Date(date).toISOString().split('T')[0];
            document.getElementById('editMemberDistance').value = distance;
            document.getElementById('editMemberArrowCount').value = arrowCount === 'N/A' ? '' : arrowCount;
            document.getElementById('editMemberScore').value = score === 'N/A' ? '' : score;
            document.getElementById('editMemberNotes').value = notes === 'No notes' ? '' : notes;

            const form = document.getElementById('editMemberLogForm');
            form.action = form.dataset.action.replace('__ID__', id);

            document.getElementById('editMemberLogModal').classList.add('active');
        }

        function closeEditLogModal() {
            document.getElementById('editMemberLogModal').classList.remove('active');
        }

        // Delete Modal Functions
        function openDeleteLogModal(btn) {
            const row = btn.closest('tr');
            const id = row.getAttribute('data-id');

            document.getElementById('deleteMemberLogId').value = id;

            const form = document.getElementById('deleteMemberLogForm');
            form.action = form.dataset.action.replace('__ID__', id);

            document.getElementById('deleteMemberLogModal').classList.add('active');
        }

        function closeDeleteLogModal() {
            document.getElementById('deleteMemberLogModal').classList.remove('active');
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            const editModal = document.getElementById('editMemberLogModal');
            const deleteModal = document.getElementById('deleteMemberLogModal');

            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == deleteModal) deleteModal.classList.remove('active');
        });

        // Initialize
        logSearch.addEventListener('input', filterTable);
        distanceFilter.addEventListener('change', filterTable);
        updatePagination();
    </script>
@endsection
