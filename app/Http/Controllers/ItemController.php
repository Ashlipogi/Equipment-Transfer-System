<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function create()
    {
        return view('additem');
    }

    public function store(Request $request)
    {
        $request->validate([
            'qty.*' => 'required|numeric',
            'description.*' => 'required|string',
            'date_purchase.*' => 'required|date',
            'property_no.*' => 'nullable|string',
            'classification_no.*' => 'nullable|string',
            'unit.*' => 'required|string',
            'total_value.*' => 'required|numeric',
        ]);

        $transfer = Transfer::create();
        $itemDescriptions = [];

        foreach ($request->qty as $index => $qty) {
            $item = Item::create([
                'transfer_id' => $transfer->id,
                'qty' => $qty,
                'description' => $request->description[$index],
                'date_purchase' => $request->date_purchase[$index],
                'property_no' => $request->property_no[$index],
                'classification_no' => $request->classification_no[$index],
                'unit' => $request->unit[$index],
                'total_value' => $request->total_value[$index],
            ]);

            $itemDescriptions[] =
                "Qty: {$item->qty}<br>" .
                "Description: {$item->description}<br>" .
                "Date Purchase: " . \Carbon\Carbon::parse($item->date_purchase)->format('m/d/Y') . "<br>" .
                "Property No: {$item->property_no}<br>" .
                "Classification No: {$item->classification_no}<br>" .
                "Unit: {$item->unit}<br>" .
                "Total Value: {$item->total_value}";
        }

        ActivityLogController::log(
            'Create Items',
            'Added new items to transfer #' . $transfer->id . ":<br><br>" . implode("<br><br>", $itemDescriptions)
        );

        return redirect()->route('transfer')->with('success', 'Item added successfully!');
    }

    public function edit(Item $item)
    {
        $transfer = Transfer::with('items')->findOrFail($item->transfer_id);
        return view('edit', compact('transfer'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'items.*' => 'required|array',
            'items.*.qty' => 'required|numeric',
            'items.*.description' => 'required|string',
            'items.*.date_purchase' => 'required|date',
            'items.*.property_no' => 'nullable|string',
            'items.*.classification_no' => 'nullable|string',
            'items.*.unit' => 'required|string',
            'items.*.total_value' => 'required|numeric',
            'deleted_items.*' => 'nullable|exists:items,id',
            'new_items.*.qty' => 'nullable|numeric',
            'new_items.*.description' => 'nullable|string',
            'new_items.*.date_purchase' => 'nullable|date',
            'new_items.*.property_no' => 'nullable|string',
            'new_items.*.classification_no' => 'nullable|string',
            'new_items.*.unit' => 'nullable|string',
            'new_items.*.total_value' => 'nullable|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Handle deleted items first
            if ($request->has('deleted_items')) {
                Item::whereIn('id', $request->deleted_items)->delete();
            }

            // Update existing items
            if ($request->has('items')) {
                foreach ($request->items as $id => $itemData) {
                    $itemToUpdate = Item::find($id);
                    if ($itemToUpdate) {
                        $itemToUpdate->update([
                            'qty' => $itemData['qty'],
                            'description' => $itemData['description'],
                            'date_purchase' => $itemData['date_purchase'],
                            'property_no' => $itemData['property_no'],
                            'classification_no' => $itemData['classification_no'],
                            'unit' => $itemData['unit'],
                            'total_value' => $itemData['total_value'],
                        ]);
                    }
                }
            }

            // Add new items
            if ($request->has('new_items')) {
                foreach ($request->new_items as $newItemData) {
                    if (!empty(array_filter($newItemData))) {
                        Item::create([
                            'transfer_id' => $item->transfer_id,
                            'qty' => $newItemData['qty'],
                            'description' => $newItemData['description'],
                            'date_purchase' => $newItemData['date_purchase'],
                            'property_no' => $newItemData['property_no'],
                            'classification_no' => $newItemData['classification_no'],
                            'unit' => $newItemData['unit'],
                            'total_value' => $newItemData['total_value'],
                        ]);
                    }
                }
            }

            DB::commit();

            ActivityLogController::log(
                'Update Items',
                "Updated items for transfer #{$item->transfer_id}"
            );

            return redirect()->route('transfer')->with('success', 'Items updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'An error occurred while updating the items. Please try again.');
        }
    }
}
