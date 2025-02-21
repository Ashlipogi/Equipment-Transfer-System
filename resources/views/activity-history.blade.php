@extends('layouts.app')

@section('content')
<title>Activity Log</title>
<div class="home-section">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <div class="p-4">
                    <table id="activityTable" class="w-full min-w-max table-auto">
                        <thead>
                            <tr>
                                <th>DATE & TIME</th>
                                <th>USER</th>
                                <th>ROLE</th>
                                <th>ACTION</th>
                                <th>DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td data-sort="{{ $activity->created_at->format('Y-m-d H:i:s') }}">{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                    <td>{{ $activity->user_name }}</td>
                                    <td>{{ $activity->user_role }}</td>
                                    <td>{{ $activity->action }}</td>
                                    <td class="description-cell">{!! $activity->description !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out hidden" style="z-index: 9999;">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Filters</h2>
            <button id="closeFilterModal" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <form id="filterForm" class="space-y-4">
            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <input type="date" class="w-full px-3 py-2 border rounded-lg" name="start_date">
                <input type="date" class="w-full px-3 py-2 border rounded-lg mt-2" name="end_date">
            </div>

            <!-- User Role -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User Role</label>
                <select class="w-full px-3 py-2 border rounded-lg" name="user_role">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <!-- Action Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Action Type</label>
                <select class="w-full px-3 py-2 border rounded-lg" name="action_type">
                    <option value="">All Actions</option>
                    <option value="create">Create</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
                </select>
            </div>

            <!-- Apply/Reset Buttons -->
            <div class="flex gap-2 pt-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                    Apply Filters
                </button>
                <button type="reset" class="flex-1 border border-gray-300 bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Overlay -->
<div class="modal-overlay fixed inset-0 bg-black bg-opacity-50 hidden" style="z-index: 9998;"></div>

<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<style>
    /* DataTables Wrapper Styles */
    .dataTables_wrapper {
        padding: 0;
        font-family: inherit;
    }

    .dataTables_length,
    .dataTables_filter {
        padding: 1rem;
        position: relative;
    }

    .dataTables_filter {
        display: flex !important;
        align-items: center;
        gap: 1rem;
    }

    .dataTables_filter::before {
        content: '';
        order: -1;
    }

    #filterButton {
        order: -1;
        background-color: #3b82f6 !important;
        display: inline-flex !important;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s;
    }

    #filterButton:hover {
        background-color: #2563eb !important;
    }

    #filterButton i {
        font-size: 1.25rem;
    }

    .dataTables_length select {
        padding: 0.5rem 2rem 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        margin: 0 0.5rem;
        background-color: white;
        width:60px!important; /* Adjust width as needed */
    }

    .dataTables_filter input {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        margin-left: 0.5rem;
        min-width: 250px;
    }

    /* Table Styles */
    #activityTable {
        width: 100% !important;
        border-collapse: collapse;
        table-layout: fixed;
    }

    #activityTable thead th {
        background-color: #f8fafc;
        padding: 1rem;
        font-weight: 600;
        text-align: left;
        font-size: 0.875rem;
        color: #4a5568;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    #activityTable tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        color: #1a202c;
    }

    #activityTable tbody tr:hover {
        background-color: #f7fafc;
    }

    .description-cell {
        max-width: 400px;
        white-space: normal !important;
        line-height: 1.5;
    }

    /* Pagination Styles */
    .dataTables_paginate {
        padding: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.25rem;
    }

    .paginate_button {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        cursor: pointer;
        background-color: white;
    }

    .paginate_button.current {
        background-color: #4299e1;
        color: white;
        border-color: #4299e1;
    }

    .paginate_button:hover:not(.current) {
        background-color: #f7fafc;
    }

    .dataTables_info {
        padding: 1rem;
        color: #4a5568;
    }

    /* Filter Modal Styles */
    #filterModal {
        z-index: 9999 !important;
    }

    #filterModal.show {
        transform: translateX(0);
        display: block;
    }

    #filterForm button[type="submit"] {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
        background-color: #4f46e5 !important;
        color: white !important;
    }

    #filterForm button[type="reset"] {
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
        background-color: white !important;
        color: #374151 !important;
    }

    #filterForm button {
        width: 100%;
        font-weight: 500;
        min-height: 40px;
    }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        display: none;
        transition: opacity 0.3s ease-in-out;
    }

    .modal-overlay.show {
        display: block;
        opacity: 1;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .dataTables_filter input {
            min-width: 200px;
        }

        .description-cell {
            max-width: 300px;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#activityTable').DataTable({
            processing: true,
            pageLength: 10,
            order: [[0, 'desc']], // Sort by first column (date) in descending order
            scrollX: true,
            language: {
                search: "Search activities:",
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
                { width: "180px", targets: 0, type: 'date' },
                { width: "120px", targets: 1 },  // User
                { width: "100px", targets: 2 },  // Role
                { width: "120px", targets: 3 },  // Action
                { width: "400px", targets: 4 }   // Description
            ],
            drawCallback: function() {
                $('.dataTables_paginate > .paginate_button').addClass('hover:bg-gray-100');
            },
            initComplete: function() {
                var filterButton = $('<button id="filterButton" class="text-white"><i class="bx bx-filter"></i>Filter</button>');
                $('.dataTables_filter').prepend(filterButton);
            }
        });

        // Custom filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var startDate = $('#filterForm [name="start_date"]').val();
            var endDate = $('#filterForm [name="end_date"]').val();
            var userRole = $('#filterForm [name="user_role"]').val();
            var actionType = $('#filterForm [name="action_type"]').val();

            var rowDate = moment(data[0], 'MMM DD, YYYY h:mm A').toDate();
            var role = data[2];
            var action = data[3];

            var dateValid = true;
            if (startDate && endDate) {
                startDate = new Date(startDate);
                endDate = new Date(endDate);
                endDate.setHours(23, 59, 59, 999);
                dateValid = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
            }

            var roleValid = !userRole || role.toLowerCase() === userRole.toLowerCase();
            var actionValid = !actionType || action.toLowerCase().includes(actionType.toLowerCase());

            return dateValid && roleValid && actionValid;
        });

        // Filter Modal Controls
        function openFilterModal() {
            $('#filterModal').addClass('show');
            $('.modal-overlay').addClass('show');
            $('body').addClass('overflow-hidden');
        }

        function closeFilterModal() {
            $('#filterModal').removeClass('show');
            $('.modal-overlay').removeClass('show');
            $('body').removeClass('overflow-hidden');
        }

        // Event Handlers
        $(document).on('click', '#filterButton', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openFilterModal();
        });

        $('#closeFilterModal').click(function(e) {
            e.preventDefault();
            closeFilterModal();
        });

        $('.modal-overlay').click(function() {
            closeFilterModal();
        });

        // Handle Filter Form Submit
        $('#filterForm').submit(function(e) {
            e.preventDefault();
            table.draw();
            closeFilterModal();
        });

        // Handle Filter Reset
        $('#filterForm button[type="reset"]').click(function() {
            $('#filterForm')[0].reset();
            table.draw();
            closeFilterModal();
        });

        // Close modal when clicking outside
        $(document).click(function(e) {
            if ($('#filterModal').hasClass('show') &&
                !$(e.target).closest('#filterModal').length &&
                !$(e.target).closest('#filterButton').length) {
                closeFilterModal();
            }
        });

        // Prevent modal from closing when clicking inside
        $('#filterModal').click(function(e) {
            e.stopPropagation();
        });
    });
</script>
@endsection
