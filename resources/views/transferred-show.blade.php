@extends('layouts.app')

@section('content')
<!-- Add Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/transferredShow.css')}}">
<div class="home-section">
<title>View Transferred Items</title>
<div class="container">
    <div class="header">
        <h1>View Transferred Items for Transfer ID: {{ $transfer->id }}</h1>
        <div>
            <a href="{{ route('transferred.edit', $transfer->id) }}" class="btn btn-primary">
                <i class='bx bx-edit'></i> Edit
            </a>
            <a href="{{ route('transferred') }}" class="btn btn-secondary">
                <i class='bx bx-arrow-back'></i> Back to List
            </a>
        </div>
    </div>

    <div class="top-fields">
        <div class="fields-row">
            <div class="field-group">
                <label>Transfer To:</label>
                <div class="field-value">{{ $transfer->items->first()->transferredItem->transfer_to ?? '' }}</div>
            </div>
            <div class="field-group">
                <label>Name/Designation:</label>
                <div class="field-value">{{ $transfer->items->first()->transferredItem->name_designation ?? '' }}</div>
            </div>
            <div class="field-group">
                <label>Position:</label>
                <div class="field-value">{{ $transfer->items->first()->transferredItem->position_intended_transfer ?? '' }}</div>
            </div>
        </div>
        <div class="fields-row">
            <div class="field-group">
                <label>Designated Office:</label>
                <div class="field-value">{{ $transfer->items->first()->transferredItem->designated_office ?? '' }}</div>
            </div>
            <div class="field-group">
                <label>Name/Designation:</label>
                <div class="field-value">{{ $transfer->items->first()->transferredItem->designated_office_name ?? '' }}</div>
            </div>
            <div class="field-group">
                <label>Position:</label>
                <div class="field-value">{{ $transfer->items->first()->transferredItem->position_intended_office ?? '' }}</div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="user-table" id="item-table">
            <thead>
                <tr>
                    <th>QTY</th>
                    <th>Description</th>
                    <th>Date Purchase</th>
                    <th>Property No.</th>
                    <th>Classification No.</th>
                    <th>Unit</th>
                    <th>Total Value</th>
                    <th>Transfer Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transfer->items as $item)
                    <tr>
                        <td>{{ $item->qty }}</td>
                        <td class="description-cell ql-editor" style="padding: 12px;">
                            {!! $item->description !!}
                        </td>
                        <td>{{ $item->date_purchase ? \Carbon\Carbon::parse($item->date_purchase)->format('Y-m-d') : '' }}</td>
                        <td>{{ $item->property_no }}</td>
                        <td>{{ $item->classification_no }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>₱{{ number_format($item->total_value, 2) }}</td>
                        <td>{{ $item->transferredItem ? \Carbon\Carbon::parse($item->transferredItem->transferred_at)->format('Y-m-d H:i:s') : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: center; border-top: 1px solid #000;">
                        SUB TOTAL: ₱{{ number_format($transfer->items->sum('total_value'), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
@endsection
