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
                <p>view your personal training sessions and progress</p>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number">24</div>
                <div class="stat-label">Total Sessions</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">6</div>
                <div class="stat-label">This Month</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">118/120</div>
                <div class="stat-label">Best Score</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">86%</div>
                <div class="stat-label">Avg Score</div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter-section">
            <div class="search-box">
                <input type="text" id="logSearch" class="search-input" placeholder="Search by date or notes...">
            </div>
            <select id="distanceFilter" class="filter-select">
                <option value="">All Distances</option>
                <option value="18m">18 Meters</option>
                <option value="25m">25 Meters</option>
                <option value="30m">30 Meters</option>
                <option value="50m">50 Meters</option>
            </select>
        </div>

        <!-- Training History Table -->
        <div class="table-wrapper">
            <table class="logs-table" id="logsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Distance</th>
                        <th>Arrow Count</th>
                        <th>Total Score</th>
                        <th>Rating</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody">
                    <tr data-distance="18m">
                        <td>03/10/2026</td>
                        <td>18m</td>
                        <td>12</td>
                        <td>108/120</td>
                        <td><span class="rating-badge excellent">⭐⭐⭐⭐⭐</span></td>
                        <td>Excellent form and accuracy</td>
                    </tr>
                    <tr data-distance="25m">
                        <td>03/08/2026</td>
                        <td>25m</td>
                        <td>12</td>
                        <td>98/120</td>
                        <td><span class="rating-badge good">⭐⭐⭐</span></td>
                        <td>Steady performance, needs posture work</td>
                    </tr>
                    <tr data-distance="30m">
                        <td>03/06/2026</td>
                        <td>30m</td>
                        <td>18</td>
                        <td>145/180</td>
                        <td><span class="rating-badge average">⭐⭐⭐⭐</span></td>
                        <td>Fine-tuning grip and alignment</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <button class="pagination-btn" id="prevBtn" onclick="previousPage()">&larr; Previous</button>
            <div class="pagination-numbers" id="paginationNumbers"></div>
            <button class="pagination-btn" id="nextBtn" onclick="nextPage()">Next &rarr;</button>
        </div>
    </div>

    <script>
        // Pagination variables
        const itemsPerPage = 5;
        let currentPage = 1;
        let allRows = [];
        let filteredRows = [];

        const logSearch = document.getElementById('logSearch');
        const distanceFilter = document.getElementById('distanceFilter');
        const rows = document.querySelectorAll('#logsTableBody tr');

        // Store all rows
        allRows = Array.from(rows);
        filteredRows = allRows;

        function filterTable() {
            const searchTerm = logSearch.value.toLowerCase();
            const selectedDistance = distanceFilter.value.toLowerCase();

            filteredRows = allRows.filter(row => {
                const dateText = row.cells[0].textContent.toLowerCase();
                const notes = row.cells[5].textContent.toLowerCase();
                const distance = row.getAttribute('data-distance').toLowerCase();

                const matchesSearch = dateText.includes(searchTerm) || notes.includes(searchTerm);
                const matchesDistance = selectedDistance === '' || distance.includes(selectedDistance);

                return matchesSearch && matchesDistance;
            });

            currentPage = 1;
            updatePagination();
        }

        function updatePagination() {
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);

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

            const pageStart = (currentPage - 1) * itemsPerPage;
            const pageEnd = pageStart + itemsPerPage;

            allRows.forEach(row => {
                row.style.display = 'none';
            });

            filteredRows.forEach((row, index) => {
                row.style.display = index >= pageStart && index < pageEnd ? '' : 'none';
            });
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
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

        filterTable();
    </script>
@endsection
