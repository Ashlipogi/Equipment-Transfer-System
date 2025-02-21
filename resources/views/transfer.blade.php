@extends('layouts.app')

@section('content')
<title>Transfer Management</title>
<div class="home-section">
    <div class="container mx-auto p-6">
        <div class="flex justify-end items-center mb-6">
            <a href="{{ route('additem') }}" style="display: inline-flex; align-items: center; background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 8px;">
            <i class='bx bx-cart-add' style="margin-right: 8px; font-size: 1.25rem;"></i>
            Add Item
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <div class="p-4">
                    <table id="transferTable" class="w-full min-w-max">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>QTY</th>
                                <th>Description</th>
                                <th>Date Purchase</th>
                                <th>Property No.</th>
                                <th>Classification No.</th>
                                <th>Unit</th>
                                <th>Total Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($groupedItems->isEmpty())
                                <tr>
                                    <td colspan="9" class="text-center py-4">No transfers found.</td>
                                </tr>
                            @else
                                @foreach($groupedItems as $item)
                                    <tr>
                                        <td>{{ $item->transfer_id }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td class="description-cell ql-editor">
                                            {!! $item->description !!}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->date_purchase)->format('m/d/Y') }}</td>
                                        <td>{{ $item->property_no }}</td>
                                        <td>{{ $item->classification_no }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td>₱{{ number_format($item->total_value, 2) }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="settings-icon" onclick="toggleDropdown({{ $item->id }})">&#9881;</button>
                                                <div id="dropdown-{{ $item->id }}" class="dropdown-content">
                                                    <a href="{{ route('transfers.show', $item->transfer_id) }}">Show</a>
                                                    <a href="{{ route('items.edit', $item->id) }}">Edit</a>
                                                    <form action="{{ route('items.transfer', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <a href="#" onclick="event.preventDefault(); showTransferModal({{ $item->id }})">Transfer</a>
                                                    </form>
                                                    <a href="#" onclick="confirmDelete({{ $item->transfer_id }})">Delete</a>
                                                </div>
                                            </div>
                                            <form id="delete-form-{{ $item->transfer_id }}"
                                                action="{{ route('transfers.destroy', $item->transfer_id) }}"
                                                method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transfer Modal -->
<div id="transferModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-xl font-semibold">Transfer Item</h2>
                        <button type="button" class="close text-gray-400 hover:text-gray-600">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>
                    <form id="transferForm" method="POST" class="p-6">
                        @csrf
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="transfer_to" class="block text-sm font-medium text-gray-700 mb-1">Transfer to:</label>
                                    <input type="text" id="transfer_to" name="transfer_to" class="w-full px-3 py-2 border rounded-lg" required>
                                </div>
                                <div>
                                    <label for="name_designation" class="block text-sm font-medium text-gray-700 mb-1">Name/Designation:</label>
                                    <input type="text" id="name_designation" name="name_designation" class="w-full px-3 py-2 border rounded-lg">
                                </div>
                            </div>
                            <div>
                                <label for="position_intended_transfer" class="block text-sm font-medium text-gray-700 mb-1">Position Intended:</label>
                                <input type="text" id="position_intended_transfer" name="position_intended_transfer" class="w-full px-3 py-2 border rounded-lg">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="designated_office" class="block text-sm font-medium text-gray-700 mb-1">Designated Office:</label>
                                    <input type="text" id="designated_office" name="designated_office" class="w-full px-3 py-2 border rounded-lg" required>
                                </div>
                                <div>
                                    <label for="designated_office_name" class="block text-sm font-medium text-gray-700 mb-1">Name/Designation:</label>
                                    <input type="text" id="designated_office_name" name="designated_office_name" class="w-full px-3 py-2 border rounded-lg">
                                </div>
                            </div>
                            <div>
                                <label for="position_intended_office" class="block text-sm font-medium text-gray-700 mb-1">Position Intended:</label>
                                <input type="text" id="position_intended_office" name="position_intended_office" class="w-full px-3 py-2 border rounded-lg">
                            </div>
                            <div class="flex justify-end gap-2 mt-6">
                                <button type="button" class="close px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                                <button type="submit" style="background-color: #2563eb;" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Transfer</button>
                            </div>
                        </div>
                    </form>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Purchase Range</label>
                <input type="date" class="w-full px-3 py-2 border rounded-lg" name="start_date">
                <input type="date" class="w-full px-3 py-2 border rounded-lg mt-2" name="end_date">
            </div>

            <!-- Property No -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Property No.</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg" name="property_no">
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
@include('components.toast')

<link rel="stylesheet" href="{{ asset('css/toast.css') }}">
<link rel="stylesheet" href="{{ asset('css/transfer.css') }}">
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script>
        @if(session('success'))
        showToast("{{ session('success') }}");
    @endif

    function showToast(message) {
        const toast = document.getElementById('toast');
        const messageEl = toast.querySelector('.message');
        messageEl.textContent = message;

        toast.classList.add('show', 'success');

        // Hide the toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
$(document).ready(function() {
    // Add modal overlay div
    $('body').append('<div class="modal-overlay"></div>');

    // Custom filtering function
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var startDate = $('#filterForm [name="start_date"]').val();
        var endDate = $('#filterForm [name="end_date"]').val();
        var propertyNo = $('#filterForm [name="property_no"]').val().toLowerCase();

        // Get date from the Date Purchase column (index 3)
        var rowDate = moment(data[3], 'MM/DD/YYYY').toDate();
        var propertyNoCell = data[4].toLowerCase(); // Property No is in the fifth column (index 4)

        // Date range check
        var dateValid = true;
        if (startDate && endDate) {
            startDate = new Date(startDate);
            endDate = new Date(endDate);
            dateValid = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
        }

        // Property No check
        var propertyNoValid = !propertyNo || propertyNoCell.includes(propertyNo);

        return dateValid && propertyNoValid;
    });

    // Initialize DataTable
    var table = $('#transferTable').DataTable({
        pageLength: 10,
        order: [[3, 'desc']], // Sort by Date Purchase by default
        scrollX: true,
        language: {
            search: "Search items:",
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
            { width: "80px", targets: 0 },    // #
            { width: "80px", targets: 1 },    // QTY
            { width: "300px", targets: 2 },   // Description
            { width: "120px", targets: 3 },   // Date Purchase
            { width: "120px", targets: 4 },   // Property No.
            { width: "150px", targets: 5 },   // Classification No.
            { width: "100px", targets: 6 },   // Unit
            { width: "120px", targets: 7 },   // Total Value
            { width: "100px", targets: 8 }    // Actions
        ],
        drawCallback: function() {
            $('.dataTables_paginate > .paginate_button').addClass('hover:bg-gray-100');
        },
        initComplete: function() {
            var filterButton = $('<button id="filterButton" class="text-white"><i class="bx bx-filter"></i>Filter</button>');
            $('.dataTables_filter').prepend(filterButton);
        }
    });

    // Filter Modal Controls
    $(document).on('click', '#filterButton', function(e) {
        e.preventDefault();
        $('#filterModal').addClass('show');
        $('.modal-overlay').addClass('show');
    });

    $('#closeFilterModal, .modal-overlay').click(function() {
        $('#filterModal').removeClass('show');
        $('.modal-overlay').removeClass('show');
    });

    // Handle Filter Form Submit
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        table.draw(); // This will apply the custom filters
        $('#filterModal').removeClass('show');
        $('.modal-overlay').removeClass('show');
    });

    // Handle Filter Reset
    $('#filterForm button[type="reset"]').click(function() {
        $('#filterForm')[0].reset();
        table.draw(); // Redraw the table with filters cleared
        $('#filterModal').removeClass('show');
        $('.modal-overlay').removeClass('show');
    });
});

// Transfer Modal functionality
let currentItemId = null;

function showTransferModal(itemId) {
    currentItemId = itemId;
    const modal = document.getElementById('transferModal');
    const form = document.getElementById('transferForm');
    form.action = `/items/${itemId}/transfer`;

    // Show modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling

    // Close the dropdown when opening the modal
    if (currentOpenDropdown) {
        currentOpenDropdown.style.display = 'none';
        currentOpenDropdown = null;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('transferModal');
    const closeButtons = modal.querySelectorAll('.close');

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    }

    closeButtons.forEach(button => {
        button.onclick = closeModal;
    });

    // Close modal when clicking outside
    modal.addEventListener('click', function(event) {
        if (event.target === modal || event.target.classList.contains('opacity-50')) {
            closeModal();
        }
    });

    // Prevent modal content clicks from closing the modal
    modal.querySelector('.bg-white').addEventListener('click', function(event) {
        event.stopPropagation();
    });
});



// Dropdown functionality
let currentOpenDropdown = null;

function toggleDropdown(index) {
    const button = event.currentTarget;
    const dropdown = document.getElementById(`dropdown-${index}`);

    // Close other open dropdowns
    if (currentOpenDropdown && currentOpenDropdown !== dropdown) {
        currentOpenDropdown.style.display = 'none';
    }

    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
        currentOpenDropdown = null;
    } else {
        dropdown.style.display = 'block';
        currentOpenDropdown = dropdown;

        // Ensure dropdown is fully visible
        const dropdownRect = dropdown.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        // Check if dropdown goes beyond right edge
        if (dropdownRect.right > viewportWidth) {
            dropdown.style.right = '0';
            dropdown.style.left = 'auto';
        }

        // Check if dropdown goes beyond bottom edge
        if (dropdownRect.bottom > viewportHeight) {
            dropdown.style.bottom = '100%';
            dropdown.style.top = 'auto';
            dropdown.style.marginTop = '0';
            dropdown.style.marginBottom = '5px';
        }
    }

    event.stopPropagation();
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.settings-icon')) {
        if (currentOpenDropdown) {
            currentOpenDropdown.style.display = 'none';
            currentOpenDropdown = null;
        }
    }
};

function confirmDelete(transferId) {
    if (confirm('Are you sure you want to delete this transfer and all its items? This action cannot be undone.')) {
        document.getElementById(`delete-form-${transferId}`).submit();
    }
}
</script>
@endsection
