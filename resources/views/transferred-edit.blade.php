@extends('layouts.app')

@section('content')
<div class="home-section">
<title>Edit Transferred Items</title>
<div class="container">
    <div class="header">
        <h1>Edit Transferred Items for Transfer ID: {{ $transfer->id }}</h1>
        <button type="button" id="add-row-btn" class="add-user-btn" style="display: inline-flex; align-items: center; background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 8px;">
            <i class='bx bx-list-plus' style="margin-right: 8px; font-size: 1.25rem;"></i>
            Add Row
        </button>
    </div>

    <form id="updateForm" action="{{ route('transfers.update', $transfer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="top-fields">
            <div class="fields-row">
                <div class="field-group">
                    <label for="global-transfer-to">Transfer To:</label>
                    <input
                        type="text"
                        id="global-transfer-to"
                        class="form-control"
                        value="{{ $transfer->items->first()->transferredItem->transfer_to ?? '' }}"
                        onchange="updateAllTransferTo(this.value)"
                    >
                </div>
                <div class="field-group">
                    <label for="global-name-designation">Name/Designation:</label>
                    <input
                        type="text"
                        id="global-name-designation"
                        class="form-control"
                        value="{{ $transfer->items->first()->transferredItem->name_designation ?? '' }}"
                        onchange="updateAllNameDesignation(this.value)"
                    >
                </div>
                <div class="field-group">
                    <label for="global-position-intended-transfer">Position:</label>
                    <input
                        type="text"
                        id="global-position-intended-transfer"
                        class="form-control"
                        value="{{ $transfer->items->first()->transferredItem->position_intended_transfer ?? '' }}"
                        onchange="updateAllPositionIntendedTransfer(this.value)"
                    >
                </div>
            </div>
            <div class="fields-row">
                <div class="field-group">
                    <label for="global-designated-office">Designated Office:</label>
                    <input
                        type="text"
                        id="global-designated-office"
                        class="form-control"
                        value="{{ $transfer->items->first()->transferredItem->designated_office ?? '' }}"
                        onchange="updateAllDesignatedOffice(this.value)"
                    >
                </div>
                <div class="field-group">
                    <label for="global-designated-office-name">Name/Designation:</label>
                    <input
                        type="text"
                        id="global-designated-office-name"
                        class="form-control"
                        value="{{ $transfer->items->first()->transferredItem->designated_office_name ?? '' }}"
                        onchange="updateAllDesignatedOfficeName(this.value)"
                    >
                </div>
                <div class="field-group">
                    <label for="global-position-intended-office">Position:</label>
                    <input
                        type="text"
                        id="global-position-intended-office"
                        class="form-control"
                        value="{{ $transfer->items->first()->transferredItem->position_intended_office ?? '' }}"
                        onchange="updateAllPositionIntendedOffice(this.value)"
                    >
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="user-table" id="item-table">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>QTY</th>
                        <th>Description</th>
                        <th>Date Purchase</th>
                        <th>Property No.</th>
                        <th>Classification No.</th>
                        <th>Unit</th>
                        <th>Total Value</th>
                        <th style="display: none;">Transferred To</th>
                        <th style="display: none;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfer->items as $index => $item)
                        <tr>
                            <td>
                                <button type="button" class="remove-row-btn" onclick="removeRow(this)">Remove</button>
                                <input type="hidden" name="deleted_items[]" value="{{ $item->id }}" disabled>
                            </td>
                            <td>
                                <input type="number" name="items[{{ $item->id }}][qty]" class="qty" value="{{ $item->qty }}" required>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $item->id }}][description]" class="description-input" value="{{ $item->description }}" readonly onclick="openDescriptionModal(this)">
                            </td>
                            <td>
                                <input type="date" name="items[{{ $item->id }}][date_purchase]" class="date-purchase" value="{{ $item->date_purchase ? $item->date_purchase->format('Y-m-d') : '' }}" required>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $item->id }}][property_no]" class="property-no" value="{{ $item->property_no }}">
                            </td>
                            <td>
                                <input type="text" name="items[{{ $item->id }}][classification_no]" class="classification-no" value="{{ $item->classification_no }}">
                            </td>
                            <td>
                                <input type="number" name="items[{{ $item->id }}][unit]" class="unit" value="{{ $item->unit }}" required>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $item->id }}][total_value]" class="total-value" value="{{ $item->total_value }}" readonly>
                            </td>
                            <td style="display: none;">
                                <input type="hidden" name="items[{{ $item->id }}][transfer_to]" class="transfer-to" value="{{ $item->transferredItem ? $item->transferredItem->transfer_to : '' }}" required>
                            </td>
                            <td style="display: none;">
                                <input type="hidden" name="items[{{ $item->id }}][name_designation]" class="name-designation" value="{{ $item->transferredItem ? $item->transferredItem->name_designation : '' }}">
                                <input type="hidden" name="items[{{ $item->id }}][position_intended_transfer]" class="position-intended-transfer" value="{{ $item->transferredItem ? $item->transferredItem->position_intended_transfer : '' }}">
                                <input type="hidden" name="items[{{ $item->id }}][designated_office]" class="designated-office" value="{{ $item->transferredItem ? $item->transferredItem->designated_office : '' }}">
                                <input type="hidden" name="items[{{ $item->id }}][designated_office_name]" class="designated-office-name" value="{{ $item->transferredItem ? $item->transferredItem->designated_office_name : '' }}">
                                <input type="hidden" name="items[{{ $item->id }}][position_intended_office]" class="position-intended-office" value="{{ $item->transferredItem ? $item->transferredItem->position_intended_office : '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-right">Sub Total</td>
                        <td colspan="3">
                            <input type="text" name="subtotal" id="subtotal" value="{{ $transfer->items->sum('total_value') }}" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <button type="submit" class="submit-btn" id="updateButton">Update</button>
        <a href="{{ route('transferred') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</div>

<!-- Modal for Editing Description -->
<div id="descriptionModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeDescriptionModal()">&times;</span>
        <h2>Item Description Editor</h2>
        <p class="modal-subtitle">Use the rich text editor below to modify the item's description</p>
        <div id="quill-editor" class="quill-editor"></div>
        <button type="button" class="save-description-btn" onclick="saveDescription()">
            <i class='bx bx-save'></i>
            Save Description
        </button>
    </div>
</div>

<!-- Include Quill CSS and JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link rel="stylesheet" href="{{asset('css/transferredEdit.css')}}">

<script>
    // Initialize Quill for the modal
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    // Form submission handling
    document.getElementById('updateForm').addEventListener('submit', function(e) {
        const updateButton = document.getElementById('updateButton');
        updateButton.disabled = true;
        updateButton.textContent = 'Updating...';
    });

    let activeDescriptionInput = null;

    function openDescriptionModal(input) {
        activeDescriptionInput = input;
        const modal = document.getElementById('descriptionModal');
        modal.style.display = 'flex';
        // Force a reflow before adding the show class
        modal.offsetHeight;
        modal.classList.add('show');
        quill.root.innerHTML = input.value;
        quill.focus();
    }

    function closeDescriptionModal() {
        const modal = document.getElementById('descriptionModal');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    function saveDescription() {
        if (activeDescriptionInput) {
            activeDescriptionInput.value = quill.root.innerHTML;
            closeDescriptionModal();
        }
    }

    // Add keyboard event listeners for modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDescriptionModal();
        }

        // Save on Ctrl/Cmd + S
        if ((event.ctrlKey || event.metaKey) && event.key === 's') {
            event.preventDefault();
            saveDescription();
        }
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('descriptionModal');
        if (event.target === modal) {
            closeDescriptionModal();
        }
    };

    function removeRow(button) {
        const row = button.closest('tr');
        const hiddenInput = row.querySelector('input[name="deleted_items[]"]');

        if (hiddenInput) {
            // For existing items
            hiddenInput.disabled = false;
            row.style.display = 'none';
        } else {
            // For newly added rows
            row.remove();
        }
        calculateSubTotal();
    }

    function calculateSubTotal() {
        const totals = Array.from(document.querySelectorAll('.total-value'))
            .filter(input => input.closest('tr').style.display !== 'none')
            .map(input => parseFloat(input.value) || 0);
        const subtotal = totals.reduce((sum, value) => sum + value, 0);
        document.getElementById('subtotal').value = subtotal.toFixed(2);
    }

    document.querySelectorAll('.qty, .unit').forEach(input => {
        input.addEventListener('input', function() {
            const row = this.closest('tr');
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const unit = parseFloat(row.querySelector('.unit').value) || 0;
            const totalValue = qty * unit;
            row.querySelector('.total-value').value = totalValue.toFixed(2);
            calculateSubTotal();
        });
    });

    function updateAllTransferTo(value) {
        document.querySelectorAll('.transfer-to').forEach(input => {
            input.value = value;
        });
    }

    function updateAllNameDesignation(value) {
        document.querySelectorAll('.name-designation').forEach(input => {
            input.value = value;
        });
    }

    function updateAllPositionIntendedTransfer(value) {
        document.querySelectorAll('.position-intended-transfer').forEach(input => {
            input.value = value;
        });
    }

    function updateAllDesignatedOffice(value) {
        document.querySelectorAll('.designated-office').forEach(input => {
            input.value = value;
        });
    }

    function updateAllDesignatedOfficeName(value) {
        document.querySelectorAll('.designated-office-name').forEach(input => {
            input.value = value;
        });
    }

    function updateAllPositionIntendedOffice(value) {
        document.querySelectorAll('.position-intended-office').forEach(input => {
            input.value = value;
        });
    }

    document.getElementById('add-row-btn').addEventListener('click', function() {
        const tableBody = document.querySelector('#item-table tbody');
        const newRow = document.createElement('tr');
        const rowId = Date.now();
        const globalTransferTo = document.getElementById('global-transfer-to').value;
        const globalNameDesignation = document.getElementById('global-name-designation').value;
        const globalPositionIntendedTransfer = document.getElementById('global-position-intended-transfer').value;
        const globalDesignatedOffice = document.getElementById('global-designated-office').value;
        const globalDesignatedOfficeName = document.getElementById('global-designated-office-name').value;
        const globalPositionIntendedOffice = document.getElementById('global-position-intended-office').value;

        newRow.innerHTML = `
            <td>
                <button type="button" class="remove-row-btn" onclick="removeRow(this)">Remove</button>
            </td>
            <td>
                <input type="number" name="new_items[${rowId}][qty]" class="qty" required>
            </td>
            <td>
                <input type="text" name="new_items[${rowId}][description]" class="description-input" readonly onclick="openDescriptionModal(this)">
            </td>
            <td>
                <input type="date" name="new_items[${rowId}][date_purchase]" class="date-purchase" required>
            </td>
            <td>
                <input type="text" name="new_items[${rowId}][property_no]" class="property-no">
            </td>
            <td>
                <input type="text" name="new_items[${rowId}][classification_no]" class="classification-no">
            </td>
            <td>
                <input type="number" name="new_items[${rowId}][unit]" class="unit" required>
            </td>
            <td>
                <input type="text" name="new_items[${rowId}][total_value]" class="total-value" readonly>
            </td>
            <td style="display: none;">
                <input type="hidden" name="new_items[${rowId}][transfer_to]" class="transfer-to" value="${globalTransferTo}" required>
            </td>
            <td style="display: none;">
                <input type="hidden" name="new_items[${rowId}][name_designation]" class="name-designation" value="${globalNameDesignation}">
                <input type="hidden" name="new_items[${rowId}][position_intended_transfer]" class="position-intended-transfer" value="${globalPositionIntendedTransfer}">
                <input type="hidden" name="new_items[${rowId}][designated_office]" class="designated-office" value="${globalDesignatedOffice}">
                <input type="hidden" name="new_items[${rowId}][designated_office_name]" class="designated-office-name" value="${globalDesignatedOfficeName}">
                <input type="hidden" name="new_items[${rowId}][position_intended_office]" class="position-intended-office" value="${globalPositionIntendedOffice}">
            </td>
        `;

        tableBody.appendChild(newRow);

        newRow.querySelectorAll('.qty, .unit').forEach(input => {
            input.addEventListener('input', function() {
                const row = this.closest('tr');
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const unit = parseFloat(row.querySelector('.unit').value) || 0;
                const totalValue = qty * unit;
                row.querySelector('.total-value').value = totalValue.toFixed(2);
                calculateSubTotal();
            });
        });
    });
</script>
@endsection
