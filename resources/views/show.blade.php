@extends('layouts.app')

@section('content')
<!-- Add Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/show.css')}}">
<div class="home-section">
<title>View Items</title>
<div class="container">
    <div class="header">
        <h1>View Items for Transfer ID: {{ $transfer->id }}</h1>
        <div>
            <a href="{{ route('transfers.edit', $transfer->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('transfer') }}" class="btn btn-secondary">Back to List</a>
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
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right">Sub Total</td>
                    <td>₱{{ number_format($transfer->items->sum('total_value'), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>

@endsection
