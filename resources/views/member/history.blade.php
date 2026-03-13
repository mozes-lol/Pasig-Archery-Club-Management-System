@extends('layouts.app')

@section('title', 'Training History')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-training-logs.css">
<style>
    #memberLogsTable .notes-col {
        text-align: center;
    }
</style>
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
        <div class="card-body">
            <table class="table" id="memberLogsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Distance</th>
                        <th>Arrow Count</th>
                        <th>Total Score</th>
                        <th>Rating</th>
                        <th class="notes-col">Notes</th>
                        <th>Coach</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr
                            data-id="{{ $log->log_id }}"
                            data-session-date="{{ $log->session_date }}"
                            data-distance="{{ $log->distance ?? '' }}"
                            data-arrow-count="{{ $log->arrow_count ?? '' }}"
                            data-total-score="{{ $log->total_score ?? '' }}"
                            data-coach-rating="{{ $log->coach_rating ?? '' }}"
                            data-technical-notes="{{ $log->technical_notes ?? '' }}"
                        >
                            <td>{{ \Carbon\Carbon::parse($log->session_date)->format('F d, Y') }}</td>
                            <td>
                                @if ($log->distance)
                                    <span class="badge badge-primary">{{ $log->distance }}m</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $log->arrow_count ?? '-' }}</td>
                            <td>{{ $log->total_score ?? '-' }}</td>
                            <td>{{ $log->coach_rating ?? '-' }}</td>
                            <td class="notes-col">{{ $log->technical_notes ?? '-' }}</td>
                            <td>{{ $log->coach_name ?? '-' }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="#" class="btn btn-sm btn-primary" onclick="openEditLogModal(this)">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger" onclick="openDeleteLogModal(this)">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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

    <div style="margin-top: 2rem;">
        <a href="/member/create-log" class="btn btn-success">➕ Add New Training Log</a>
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
                        <input type="number" id="editMemberDistance" name="distance" class="form-input" min="1" max="2147483647">
                    </div>
                    <div class="form-group">
                        <label>Arrow Count</label>
                        <input type="number" id="editMemberArrowCount" name="arrow_count" class="form-input" min="1" max="2147483647">
                    </div>
                    <div class="form-group">
                        <label>Total Score</label>
                        <input type="number" id="editMemberScore" name="total_score" class="form-input" min="0" max="2147483647">
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
        function openEditLogModal(btn) {
            const row = btn.closest('tr');
            const id = row.getAttribute('data-id');
            const date = row.dataset.sessionDate || '';
            const distance = row.dataset.distance || '';
            const arrowCount = row.dataset.arrowCount || '';
            const score = row.dataset.totalScore || '';
            const rating = row.dataset.coachRating || '';
            const notes = row.dataset.technicalNotes || '';

            document.getElementById('editMemberLogId').value = id;
            document.getElementById('editMemberDate').value = date;
            document.getElementById('editMemberDistance').value = distance;
            document.getElementById('editMemberArrowCount').value = arrowCount;
            document.getElementById('editMemberScore').value = score;
            document.getElementById('editMemberRating').value = rating;
            document.getElementById('editMemberNotes').value = notes;

            const form = document.getElementById('editMemberLogForm');
            form.action = form.dataset.action.replace('__ID__', id);

            document.getElementById('editMemberLogModal').classList.add('active');
        }

        function closeEditLogModal() {
            document.getElementById('editMemberLogModal').classList.remove('active');
        }

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

        window.addEventListener('click', function(e) {
            const editModal = document.getElementById('editMemberLogModal');
            const deleteModal = document.getElementById('deleteMemberLogModal');

            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == deleteModal) deleteModal.classList.remove('active');
        });
    </script>
@endsection
