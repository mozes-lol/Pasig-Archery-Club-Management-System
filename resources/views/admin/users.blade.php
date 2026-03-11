@extends('layouts.app')

@section('title', 'User Management')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/admin-users.css">
@endpush

@section('content')
    <div class="user-management">
        <!-- Header with Create User Button -->
        <div class="management-header">
            <div class="header-text">
                <h1>User Management</h1>
                <p>create, edit, and manage user accounts and roles</p>
            </div>
            <button class="btn-create-user" onclick="openCreateModal()">
                <i class="fas fa-plus"></i>
                Create User
            </button>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-number">50</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">8</div>
                <div class="stat-label">Pending Approval</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">45</div>
                <div class="stat-label">Total Archers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">5</div>
                <div class="stat-label">Total Coaches</div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter-section">
            <div class="search-box">
                <input type="text" id="userSearch" class="search-input" placeholder="Search by name or email...">
            </div>
            <select id="roleFilter" class="filter-select">
                <option value="">All Roles</option>
                <option value="archer">Archer</option>
                <option value="coach">Coach</option>
                <option value="admin">Admin</option>
            </select>
            <select id="statusFilter" class="filter-select">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <!-- Users Table -->
        <div class="table-wrapper">
            <table class="users-table" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr data-role="member" data-status="active">
                        <td>John Archer</td>
                        <td>john@example.com</td>
                        <td><span class="role-badge member">Member</span></td>
                        <td><span class="status-badge active">Active</span></td>
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
                    <tr data-role="coach" data-status="active">
                        <td>Maria Coach</td>
                        <td>maria@example.com</td>
                        <td><span class="role-badge coach">Coach</span></td>
                        <td><span class="status-badge active">Active</span></td>
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
                    <tr data-role="member" data-status="inactive">
                        <td>Pedro Member</td>
                        <td>pedro@example.com</td>
                        <td><span class="role-badge member">Member</span></td>
                        <td><span class="status-badge inactive">Inactive</span></td>
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
                    <tr data-role="admin" data-status="active">
                        <td>Admin User</td>
                        <td>admin@example.com</td>
                        <td><span class="role-badge admin">Admin</span></td>
                        <td><span class="status-badge active">Active</span></td>
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
                    <tr data-role="member" data-status="active">
                        <td>Ana Rodriguez</td>
                        <td>ana@example.com</td>
                        <td><span class="role-badge member">Member</span></td>
                        <td><span class="status-badge active">Active</span></td>
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

    <!-- Create User Modal -->
    <div id="createUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New User</h2>
                <button class="modal-close" onclick="closeCreateModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" placeholder="Enter first name" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" placeholder="Enter last name" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Enter email address" class="form-input">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-input">
                        <option>Select role...</option>
                        <option>Member</option>
                        <option>Coach</option>
                        <option>Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeCreateModal()">Cancel</button>
                <button class="modal-btn-submit">Create User</button>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit User</h2>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="editFirstName" placeholder="Enter first name" class="form-input">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" id="editLastName" placeholder="Enter last name" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="editEmail" placeholder="Enter email address" class="form-input">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select id="editRole" class="form-input">
                        <option>Select role...</option>
                        <option>Member</option>
                        <option>Coach</option>
                        <option>Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button class="modal-btn-submit">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div id="deleteUserModal" class="modal">
        <div class="modal-content modal-danger">
            <div class="modal-header">
                <h2>Delete User</h2>
                <button class="modal-close" onclick="closeDeleteModal()">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="deleteName"></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="modal-btn-delete">Delete User</button>
            </div>
        </div>
    </div>

    <script>
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

        // Pagination variables
        const itemsPerPage = 5;
        let currentPage = 1;
        let allRows = [];

        const userSearch = document.getElementById('userSearch');
        const roleFilter = document.getElementById('roleFilter');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('#usersTableBody tr');

        // Store all rows
        allRows = Array.from(rows);

        function filterTable() {
            const searchTerm = userSearch.value.toLowerCase();
            const selectedRole = roleFilter.value.toLowerCase();
            const selectedStatus = statusFilter.value.toLowerCase();

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const role = row.getAttribute('data-role').toLowerCase();
                const status = row.getAttribute('data-status').toLowerCase();

                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = selectedRole === '' || role.includes(selectedRole);
                const matchesStatus = selectedStatus === '' || status.includes(selectedStatus);

                row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
            });

            currentPage = 1;
            updatePagination();
        }

        function updatePagination() {
            const visibleRows = Array.from(document.querySelectorAll('#usersTableBody tr')).filter(row => row.style.display !== 'none');
            const totalPages = Math.ceil(visibleRows.length / itemsPerPage);

            // Update page buttons visibility
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;

            // Generate page numbers with ellipsis
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

            // Hide/show table rows based on current page
            visibleRows.forEach((row, index) => {
                const pageStart = (currentPage - 1) * itemsPerPage;
                const pageEnd = pageStart + itemsPerPage;
                row.style.display = index >= pageStart && index < pageEnd ? '' : 'none';
            });
        }

        function nextPage() {
            const visibleRows = Array.from(document.querySelectorAll('#usersTableBody tr')).filter(row => row.style.display !== 'none');
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

        userSearch.addEventListener('input', filterTable);
        roleFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // Initialize pagination on page load
        updatePagination();

        // Modal functions
        function openCreateModal() {
            document.getElementById('createUserModal').classList.add('active');
        }

        function closeCreateModal() {
            document.getElementById('createUserModal').classList.remove('active');
        }

        function openEditModal(btn) {
            const row = btn.closest('tr');
            const fullName = row.cells[0].textContent;
            const nameParts = fullName.trim().split(' ');
            const firstName = nameParts[0];
            const lastName = nameParts.slice(1).join(' ');
            const email = row.cells[1].textContent;
            const role = row.cells[2].textContent.trim();

            document.getElementById('editFirstName').value = firstName;
            document.getElementById('editLastName').value = lastName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role.charAt(0).toUpperCase() + role.slice(1);

            document.getElementById('editUserModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editUserModal').classList.remove('active');
        }

        function openDeleteModal(btn) {
            const row = btn.closest('tr');
            const name = row.cells[0].textContent;
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteUserModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteUserModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('createUserModal');
            const editModal = document.getElementById('editUserModal');
            const deleteModal = document.getElementById('deleteUserModal');

            if (e.target == createModal) createModal.classList.remove('active');
            if (e.target == editModal) editModal.classList.remove('active');
            if (e.target == deleteModal) deleteModal.classList.remove('active');
        });

        // Add loader functionality to form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Create User button
            const createUserBtn = document.querySelector('#createUserModal .modal-btn-submit');
            if (createUserBtn) {
                createUserBtn.addEventListener('click', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Creating user account...");
                        // Simulate submission with 2 second delay
                        setTimeout(() => {
                            if (window.ArcheryLoader) ArcheryLoader.hide();
                            closeCreateModal();
                        }, 2000);
                    }
                });
            }

            // Edit User button
            const editUserBtn = document.querySelector('#editUserModal .modal-btn-submit');
            if (editUserBtn) {
                editUserBtn.addEventListener('click', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Saving user changes...");
                        // Simulate submission with 2 second delay
                        setTimeout(() => {
                            if (window.ArcheryLoader) ArcheryLoader.hide();
                            closeEditModal();
                        }, 2000);
                    }
                });
            }

            // Delete User button
            const deleteUserBtn = document.querySelector('#deleteUserModal .modal-btn-delete');
            if (deleteUserBtn) {
                deleteUserBtn.addEventListener('click', function() {
                    if (window.ArcheryLoader) {
                        ArcheryLoader.show();
                        ArcheryLoader.setMessage("Deleting user account...");
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