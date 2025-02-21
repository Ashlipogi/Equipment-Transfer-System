@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/transferred.css') }}">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<title>Transferred Items</title>
<div class="home-section">
    <div class="container mx-auto p-6">

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <div class="p-4">
                    <table id="transferredTable" class="w-full min-w-max">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transferred To <br> Name/Designation <br> Position</th>
                                <th>Designated Office <br> Name/Designation <br> Position</th>
                                <th>Transfer Date</th>
                                <th>Sub Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transferredItems as $transferred)
                                @php
                                    $subtotal = App\Models\Item::where('transfer_id', $transferred->item->transfer_id)
                                        ->sum('total_value');
                                @endphp
                                <tr>
                                    <td>{{ $transferred->item->transfer_id }}</td>
                                    <td><strong>Transferred To:</strong>{{ $transferred->transfer_to }}<br><strong>Name/Designation:</strong>{{ $transferred->name_designation }}<br><strong>Position:</strong>{{ $transferred->position_intended_transfer }}</td>
                                    <td><strong>Designated Office:</strong>{{ $transferred->designated_office }}<br><strong>Name/Designation:</strong>{{ $transferred->designated_office_name }}<br><strong>Position:</strong>{{ $transferred->position_intended_office }}</td>
                                    <td>{{ $transferred->transferred_at ? Carbon\Carbon::parse($transferred->transferred_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i A') : '' }}</td>
                                    <td>₱{{ number_format($subtotal, 2) }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="settings-icon" onclick="toggleDropdown({{ $transferred->item->id }})">&#9881;</button>
                                            <div id="dropdown-{{ $transferred->item->id }}" class="dropdown-content">
                                                <a href="{{ route('transferred.show', $transferred->item->transfer_id) }}">View Details</a>
                                                <a href="{{ route('transferred.edit', $transferred->item->transfer_id) }}">Edit</a>
                                                <a href="#" onclick="printTransfer({{ $transferred->item->transfer_id }})">Print</a>
                                                <a href="#" onclick="confirmDelete({{ $transferred->item->transfer_id }})">Delete</a>
                                            </div>
                                        </div>
                                        <form id="delete-form-{{ $transferred->item->transfer_id }}"
                                            action="{{ route('transfers.destroy', $transferred->item->transfer_id) }}"
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

<!-- Print Template -->
<div id="print-template" style="display: none;">
    <table>
        <tr>
            <td class="gen-header" style="font-size: 10px;">Gen. Form No. 30-A</td>
        </tr>
        <tr>
            <td class="invoice-header" style="text-align: center;">
                INVOICE RECEIPT FOR PROPERTY
            </td>
        </tr>
        <tr>
            <td class="blank-bottom">&nbsp;</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">QTY</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">Description</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">Date<br>Purchase</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">Property<br>No.</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">Classification<br>No.</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">Unit Value</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">Total Value</th>
            </tr>
        </thead>
        <tbody id="print-body">
            <!-- Rows dynamically inserted by JS -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="border: 1px solid #000; padding: 8px; text-align: center;">
                    SUB TOTAL: <span id="print-total">₱0.00</span>
                </td>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: -21px;">
        <tr>
            <td style="width: 50%; padding: 10px; text-align: center; vertical-align: top; border-right: 1px solid #000;">
                <div style="text-align: center; margin-bottom: 10px; color: #007bff;">INVOICE</div>
                <div style="text-align: left; margin-bottom: 20px;">
                    this is to certify that I have this _____, day<br>
                    of _____ 20_____ transferred to.
                </div>
                <div style="text-align: center; margin-bottom: 10px;">
                    <strong id="print-transfer-to"></strong><br>
                </div>
                <div style="text-align: center; margin-bottom: 20px;">
                    <strong id="print-name-designation"></strong><br>
                    <div style="color: red">Name/Designation</div>
                </div>
                <div style="text-align: center;">
                    the above listed supplies or property<br>
                    <strong><span id="print-position-intended-transfer"></span></strong>
                </div>
            </td>
            <td style="width: 50%; padding: 10px; text-align: center; vertical-align: top;">
                <div style="text-align: center; margin-bottom: 10px; color: #007bff;">RECEIPT</div>
                <div style="text-align: left; margin-bottom: 20px;">
                    this is to certify that I have this _____, day of _____
                    20_____ received from.
                </div>
                <div style="text-align: center; margin-bottom: 10px;">
                    <strong id="print-designated-office"></strong><br>
                </div>
                <div style="text-align: center; margin-bottom: 20px;">
                    <strong id="print-designated-office-name"></strong><br>
                    <div style="color: red">Name/Designation</div>
                </div>
                <div style="text-align: center;">
                    the above listed supplies or property<br>
                    <strong><span id="print-position-intended-office"></span></strong>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; padding: 10px; text-align: center; border-top: 1px solid #000000; border-right: 1px solid #000; font-size: 13px; color: #007bff;">
                <strong>Invoicing Accountable Officer</strong>
            </td>
            <td style="width: 50%; padding: 10px; text-align: center; border-top: 1px solid #000; font-size: 13px; color: #007bff;">
                <strong>Receiving Accountable Officer</strong>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 100%; border: 1px solid #000; padding: 8px; text-align: center;">
                This certify that I recommended the foregoing transfer of Supplies or Property<br><br>
                <strong>MR. EMMANUEL E. LAVADOR</strong><br>
                General Service Officer -Designate / Local Treasurer<br><br>
                <div style="text-align: left">
                    Date: _________________
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 100%; border: 1px solid #000; padding: 8px; text-align: center;">
                This certificate that I approved the foregoing transfer of Supplies or Property<br><br>
                <strong>HON. CESAR S. CUMBA JR.</strong><br>
                Local Chief Executive<br><br>
                <div style="text-align: left">
                    Date: _________________
                </div>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                <div style="text-align: left">Transfer Witness By:<br><br></div>
                <strong>MS. AURA C. CADENAS</strong><br>
                Municipal Accountant<br>
                Provincial/City/Municipal Auditor<br><br>
            </td>
        </tr>
    </table>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Date Range</label>
                <input type="date" class="w-full px-3 py-2 border rounded-lg" name="start_date">
                <input type="date" class="w-full px-3 py-2 border rounded-lg mt-2" name="end_date">
            </div>

            <!-- Transferred To -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Transferred To</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg" name="transfer_to">
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

@include('components.toast')
<link rel="stylesheet" href="{{ asset('css/toast.css') }}">
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script>
    // Add this after $(document).ready(function() {
    // Check for flash messages
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
    // Custom filtering function
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var startDate = $('#filterForm [name="start_date"]').val();
        var endDate = $('#filterForm [name="end_date"]').val();
        var transferTo = $('#filterForm [name="transfer_to"]').val().toLowerCase();

        // Get date from the Transfer Date column (index 3)
        var rowDate = moment(data[3], 'MMMM D, YYYY, h:mm A').toDate();
        var transferToCell = data[1].toLowerCase(); // Transfer To is in the second column

        // Date range check
        var dateValid = true;
        if (startDate && endDate) {
            startDate = new Date(startDate);
            endDate = new Date(endDate);
            // Set the time to end of day for the end date
            endDate.setHours(23, 59, 59, 999);
            dateValid = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
        }

        // Transfer To check
        var transferToValid = !transferTo || transferToCell.includes(transferTo);

        return dateValid && transferToValid;
    });

    // Initialize DataTable
    var table = $('#transferredTable').DataTable({
        pageLength: 10,
        order: [[3, 'desc']], // Sort by Transfer Date by default
        scrollX: true,
        language: {
            search: "Search transfers:",
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
            { width: "50px", targets: 0 },    // #
            { width: "300px", targets: 1 },   // Transferred To
            { width: "300px", targets: 2 },   // Designated Office
            { width: "150px", targets: 3 },   // Transfer Date
            { width: "100px", targets: 4 },   // Sub Total
            { width: "100px", targets: 5 }    // Actions
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

        // Close modal when clicking outside
        $(document).click(function(e) {
            if ($('#filterModal').hasClass('show') &&
                !$(e.target).closest('#filterModal').length &&
                !$(e.target).closest('#filterButton').length) {
                closeFilterModal();
            }
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

    function printTransfer(transferId) {
    fetch(`/transferred/${transferId}/items`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.length === 0) {
                alert("No data found for this transfer.");
                return;
            }

            // Create an iframe for printing
            var iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.width = '0px';
            iframe.style.height = '0px';
            iframe.style.border = 'none';
            document.body.appendChild(iframe);

            // Clone the hidden print template
            var printTemplate = document.getElementById('print-template').cloneNode(true);
            printTemplate.style.display = 'block';

            // Get all elements that need to be updated
            var printBody = printTemplate.querySelector('#print-body');
            var printTotal = printTemplate.querySelector('#print-total');
            var transferToEl = printTemplate.querySelector('#print-transfer-to');
            var nameDesignationEl = printTemplate.querySelector('#print-name-designation');
            var positionIntendedTransferEl = printTemplate.querySelector('#print-position-intended-transfer');
            var designatedOfficeEl = printTemplate.querySelector('#print-designated-office');
            var designatedOfficeNameEl = printTemplate.querySelector('#print-designated-office-name');
            var positionIntendedOfficeEl = printTemplate.querySelector('#print-position-intended-office');

            // Get the first item for the transfer details
            const firstItem = data[0];

            // Update all the dynamic elements
            transferToEl.textContent = firstItem.transfer_to || '';
            nameDesignationEl.textContent = firstItem.name_designation || '';
            positionIntendedTransferEl.textContent = firstItem.position_intended_transfer || '';
            designatedOfficeEl.textContent = firstItem.designated_office || '';
            designatedOfficeNameEl.textContent = firstItem.designated_office_name || '';
            positionIntendedOfficeEl.textContent = firstItem.position_intended_office || '';

            printBody.innerHTML = '';
            let grandTotal = 0;

            // Helper function to check for null values
            const isNullOrNullString = (value) => {
                return value === null || value === 'null' || value === undefined || value === '';
            };

            // Build the items table
            data.forEach(item => {
                let unitValue = 0;
                if (parseFloat(item.qty) > 0) {
                    unitValue = parseFloat(item.total_value) / parseFloat(item.qty);
                }

                let row = `
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">${item.qty}</td>
                        <td style="border: 1px solid #000; padding: 8px;">${item.description}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">${item.date_purchase}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">${isNullOrNullString(item.property_no) ? '' : item.property_no}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: center;">${isNullOrNullString(item.classification_no) ? '' : item.classification_no}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: right;">₱${unitValue.toFixed(2)}</td>
                        <td style="border: 1px solid #000; padding: 8px; text-align: right;">₱${parseFloat(item.total_value).toFixed(2)}</td>
                    </tr>
                `;
                printBody.innerHTML += row;
                grandTotal += parseFloat(item.total_value);
            });

            // Update total
            printTotal.textContent = `₱${grandTotal.toFixed(2)}`;

            // Write to iframe and print
            var doc = iframe.contentWindow.document;
            doc.open();
            doc.write('<html><head><title>Print</title>');
            doc.write('<style>');
            doc.write(`
                @page {
                    margin: 10px;
                }
                body {
                    margin: 0;
                    padding: 20px;
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                }
                .invoice-header {
                    background-color: red !important;
                    border-top: none !important;
                    border-bottom: none !important;
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                }
                .gen-header {
                    text-align: left;
                    font-size: 10px;
                }
                .blank-bottom {
                    border-top: none !important;
                    border-bottom: none !important;
                }
            `);
            doc.write('</style></head><body>');
            doc.write(printTemplate.outerHTML);
            doc.write('</body></html>');
            doc.close();

            // Print after iframe loads
            iframe.onload = function () {
                iframe.contentWindow.print();
                setTimeout(() => {
                    document.body.removeChild(iframe);
                }, 500);
            };
        })
        .catch(error => {
            console.error('Error fetching transfer data:', error);
            alert('An error occurred while fetching data.');
        });
}
</script>
@endsection
