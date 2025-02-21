@extends('layouts.app')

@section('content')
<div class="home-section">
<title>Add Item</title>
<div class="container">
    <div class="header" style="display: flex; justify-content: flex-end;">
        <button type="button" id="add-row-btn" class="add-user-btn" style="display: inline-flex; align-items: center; background-color: #2563eb; color: white; padding: 10px 16px; border-radius: 8px;">
            <i class='bx bx-list-plus' style="margin-right: 8px; font-size: 1.25rem;"></i>
            Add Row
        </button>
    </div>
    <form id="addItemForm" action="{{ route('items.store') }}" method="POST">
        @csrf
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
                    </tr>
                </thead>
                <tbody>
                    <!-- Initial Row -->
                    <tr>
                        <td>
                            <button type="button" class="remove-row-btn">Remove</button>
                        </td>
                        <td><input type="number" name="qty[]" class="qty" required></td>
                        <td>
                            <input type="text" name="description[]" class="description-input" readonly onclick="openDescriptionModal(this)">
                        </td>
                        <td><input type="date" name="date_purchase[]" class="date-purchase" required></td>
                        <td><input type="text" name="property_no[]" class="property-no"></td>
                        <td><input type="text" name="classification_no[]" class="classification-no"></td>
                        <td><input type="number" name="unit[]" class="unit" required></td>
                        <td><input type="text" name="total_value[]" class="total-value" readonly></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-right">Sub Total</td>
                        <td><input type="text" name="subtotal" id="subtotal" readonly></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <button type="submit" class="submit-btn" id="submitButton">Submit</button>
    </form>
</div>

</div>
<!-- Modal for Editing Description -->
<div id="quill-modal" class="modal" style="display: none;">
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
<link rel="stylesheet" href="{{asset('css/additem.css')}}">

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
    document.getElementById('addItemForm').addEventListener('submit', function(e) {
        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';
    });

    let activeDescriptionInput = null;

    function openDescriptionModal(input) {
        activeDescriptionInput = input;
        const modal = document.getElementById('quill-modal');
        modal.style.display = 'flex';
        // Force a reflow before adding the show class
        modal.offsetHeight;
        modal.classList.add('show');
        quill.root.innerHTML = input.value;
        quill.focus();
    }

    function closeDescriptionModal() {
        const modal = document.getElementById('quill-modal');
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
        const modal = document.getElementById('quill-modal');
        if (event.target === modal) {
            closeDescriptionModal();
        }
    };

    // Function to calculate total value for each row
    function calculateTotalValue() {
        const row = this.closest('tr');
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const unit = parseFloat(row.querySelector('.unit').value) || 0;
        const totalValue = qty * unit;
        row.querySelector('.total-value').value = totalValue.toFixed(2);
        calculateSubTotal();
    }

    // Function to calculate subtotal
    function calculateSubTotal() {
        const totals = Array.from(document.querySelectorAll('.total-value')).map(input => parseFloat(input.value) || 0);
        const subtotal = totals.reduce((sum, value) => sum + value, 0);
        document.getElementById('subtotal').value = subtotal.toFixed(2);
    }

    // Add event listeners to initial row inputs
    document.querySelectorAll('.qty, .unit').forEach(input => {
        input.addEventListener('input', calculateTotalValue);
    });

    // Add event listener to initial remove button
    document.querySelector('.remove-row-btn').addEventListener('click', function() {
        const row = this.closest('tr');
        if (document.querySelectorAll('#item-table tbody tr').length > 1) {
            row.remove();
            calculateSubTotal();
        }
    });

    // Add Row functionality
    document.getElementById('add-row-btn').addEventListener('click', function() {
        const tableBody = document.querySelector('#item-table tbody');
        const newRow = document.createElement('tr');
        const rowId = tableBody.children.length + 1;

        newRow.innerHTML = `
            <td>
                <button type="button" class="remove-row-btn">Remove</button>
            </td>
            <td><input type="number" name="qty[]" class="qty" required></td>
            <td>
                <input type="text" name="description[]" class="description-input" readonly onclick="openDescriptionModal(this)">
            </td>
            <td><input type="date" name="date_purchase[]" class="date-purchase" required></td>
            <td><input type="text" name="property_no[]" class="property-no"></td>
            <td><input type="text" name="classification_no[]" class="classification-no"></td>
            <td><input type="number" name="unit[]" class="unit" required></td>
            <td><input type="text" name="total_value[]" class="total-value" readonly></td>
        `;

        tableBody.appendChild(newRow);

        // Add event listeners to the new row
        newRow.querySelectorAll('.qty, .unit').forEach(input => {
            input.addEventListener('input', calculateTotalValue);
        });

        newRow.querySelector('.remove-row-btn').addEventListener('click', function() {
            newRow.remove();
            calculateSubTotal();
        });
    });
</script>
@endsection
