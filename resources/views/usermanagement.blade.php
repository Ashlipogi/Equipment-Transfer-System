@extends('layouts.app')

@section('content')
<title>User Management</title>
<div class="home-section">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex justify-end w-full">
                <button onclick="openModal()" style="display: inline-flex; align-items: center; background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 8px;">
                    <i class='bx bx-user-plus' style="margin-right: 8px; font-size: 1.25rem;"></i>
                    Add User
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <div class="p-4">
                    <table id="userTable" class="w-full min-w-max">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Password</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="role-badge {{ $user->role === 'admin' ? 'admin' : 'user' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>••••••••</td>
                                    <td>{{ $user->created_at->format('F j, Y, g:iA') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="settings-icon" onclick="toggleDropdown({{ $index }})">&#9881;</button>
                                            <div id="dropdown-{{ $index }}" class="dropdown-content">
                                                <a href="#" onclick="openEditModal({{ $user->id }})">Edit</a>
                                                <a href="#" onclick="confirmDelete({{ $user->id }})">Delete</a>
                                            </div>
                                        </div>
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('users.destroy', $user->id) }}"
                                            method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Create User Modal -->
    <div id="createUserModal" class="modal">
        <div class="modal-content">
            <button type="button" class="close-btn" onclick="closeModal()">
                <i class='bx bx-x'></i>
            </button>
            <h2>Create User</h2>
            <p class="modal-subtitle">Add a new user to the system</p>

            <form action="{{ route('users.store') }}" method="POST" onsubmit="handleSubmit(event)">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button id="createUserBtn" type="submit" class="btn btn-primary">
                        <span id="btnText">Create User</span>
                        <span id="loadingSpinner" class="hidden">
                            <i class='bx bx-loader-alt bx-spin'></i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <button type="button" class="close-btn" onclick="closeEditModal()">
                <i class='bx bx-x'></i>
            </button>
            <h2>Edit User</h2>
            <p class="modal-subtitle">Modify user information</p>

            <form id="editUserForm" method="POST" onsubmit="handleEditSubmit(event)">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit-name" class="form-label">Name</label>
                    <input type="text" id="edit-name" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit-email" class="form-label">Email</label>
                    <input type="email" id="edit-email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="edit-role" class="form-label">Role</label>
                    <select id="edit-role" name="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit-password" class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" id="edit-password" name="password" class="form-input">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button id="updateUserBtn" type="submit" class="btn btn-primary">
                        <span id="updateBtnText">Update User</span>
                        <span id="updateLoadingSpinner" class="hidden">
                            <i class='bx bx-loader-alt bx-spin'></i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>


<!-- Toast Notification Component -->
@include('components.toast')

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/toast.css') }}">
<link rel="stylesheet" href="{{ asset('css/usermanagement.css') }}">
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    function handleEditSubmit(event) {
        event.preventDefault();
        let updateUserBtn = document.getElementById("updateUserBtn");
        let updateBtnText = document.getElementById("updateBtnText");
        let updateLoadingSpinner = document.getElementById("updateLoadingSpinner");

        updateUserBtn.disabled = true;
        updateBtnText.textContent = "Updating...";
        updateLoadingSpinner.classList.remove("hidden");

        event.target.submit();
    }

    function handleSubmit(event) {
        event.preventDefault();
        let createUserBtn = document.getElementById("createUserBtn");
        let btnText = document.getElementById("btnText");
        let loadingSpinner = document.getElementById("loadingSpinner");

        createUserBtn.disabled = true;
        btnText.textContent = "Creating...";
        loadingSpinner.classList.remove("hidden");

        event.target.submit();
    }

    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#userTable').DataTable({
            pageLength: 10,
            order: [[5, 'desc']],
            scrollX: true,
            language: {
                search: "Search users:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            columnDefs: [
                { width: "80px", targets: 0 },
                { width: "200px", targets: 1 },
                { width: "200px", targets: 2 },
                { width: "120px", targets: 3 },
                { width: "120px", targets: 4 },
                { width: "180px", targets: 5 },
                { width: "100px", targets: 6 }
            ],
            drawCallback: function() {
                $('.dataTables_paginate > .paginate_button').addClass('hover:bg-gray-100');
            }
        });

        // Check for success message and show toast instead of modal
        @if(session('success'))
            // Delay the toast slightly to ensure smooth page load
            setTimeout(() => {
                showToast("{{ session('success') }}");
            }, 300);
        @endif

        // Close any open modals on page load
        closeModal();
        closeEditModal();
    });

    function showToast(message) {
        const toast = document.getElementById('toast');
        const messageEl = toast.querySelector('.message');
        messageEl.textContent = message;

        toast.classList.add('show', 'success');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function openModal() {
        const modal = document.getElementById('createUserModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('createUserModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
            // Reset form
            const form = modal.querySelector('form');
            if (form) form.reset();
        }
    }

    function openEditModal(userId) {
        fetch(`/users/${userId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-name').value = data.name;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-role').value = data.role;
                document.getElementById('editUserForm').action = `/users/${userId}`;
                const modal = document.getElementById('editUserModal');
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                showToast('Error loading user data. Please try again.');
            });
    }

    function closeEditModal() {
        const modal = document.getElementById('editUserModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
            // Reset form
            const form = modal.querySelector('form');
            if (form) form.reset();
        }
    }

    let currentOpenDropdown = null;

    function toggleDropdown(index) {
        const button = event.currentTarget;
        const dropdown = document.getElementById(`dropdown-${index}`);

        if (currentOpenDropdown && currentOpenDropdown !== dropdown) {
            currentOpenDropdown.style.display = 'none';
        }

        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
            currentOpenDropdown = null;
        } else {
            dropdown.style.display = 'block';
            currentOpenDropdown = dropdown;

            const dropdownRect = dropdown.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;

            if (dropdownRect.right > viewportWidth) {
                dropdown.style.right = '0';
                dropdown.style.left = 'auto';
            }

            if (dropdownRect.bottom > viewportHeight) {
                dropdown.style.bottom = '100%';
                dropdown.style.top = 'auto';
                dropdown.style.marginTop = '0';
                dropdown.style.marginBottom = '5px';
            }
        }

        event.stopPropagation();
    }

    window.onclick = function(event) {
        if (!event.target.matches('.settings-icon')) {
            if (currentOpenDropdown) {
                currentOpenDropdown.style.display = 'none';
                currentOpenDropdown = null;
            }
        }
    };

    function confirmDelete(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            document.getElementById(`delete-form-${userId}`).submit();
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const createModal = document.getElementById('createUserModal');
        const editModal = document.getElementById('editUserModal');

        if (event.target.classList.contains('modal')) {
            if (createModal && createModal.classList.contains('show')) {
                closeModal();
            }
            if (editModal && editModal.classList.contains('show')) {
                closeEditModal();
            }
        }
    });

    // Close modals on page load and escape key
    document.addEventListener('DOMContentLoaded', function() {
        closeModal();
        closeEditModal();
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeEditModal();
        }
    });
</script>
@endsection
