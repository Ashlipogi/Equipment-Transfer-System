<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Item;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Add this new route to fetch items by transfer_id
Route::get('/transfers/{transferId}/items', function ($transferId) {
    $items = Item::where('transfer_id', $transferId)
        ->with('transferredItem')
        ->get()
        ->map(function ($item) {
            return [
                'qty' => $item->qty,
                'description' => $item->description,
                'date_purchase' => $item->date_purchase,
                'property_no' => $item->property_no,
                'classification_no' => $item->classification_no,
                'unit' => $item->unit,
                'total_value' => $item->total_value,
            ];
        });

    return response()->json($items);
});
