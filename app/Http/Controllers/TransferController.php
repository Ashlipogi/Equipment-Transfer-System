<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Item;
use App\Models\TransferredItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransferController extends Controller
{
    public function index()
    {
        // Load transfers with items that haven't been transferred
        $transfers = Transfer::with(['items' => function($query) {
            $query->whereDoesntHave('transferredItem');
        }])->get();

        $groupedItems = collect();
        foreach ($transfers as $transfer) {
            $firstItem = $transfer->items->first();
            if ($firstItem) {
                $groupedItems->push($firstItem);
            }
        }
        return view('transfer', compact('groupedItems'));
    }

    public function transferItem(Request $request, Item $item)
    {
        $request->validate([
            'transfer_to' => 'required|string|max:255',
            'name_designation' => 'required|string|max:255',
            'position_intended_transfer' => 'required|string|max:255',
            'designated_office' => 'required|string|max:255',
            'designated_office_name' => 'required|string|max:255',
            'position_intended_office' => 'required|string|max:255'
        ]);

        // Get all items from the same transfer
        $items = Item::where('transfer_id', $item->transfer_id)
                    ->whereDoesntHave('transferredItem')
                    ->get();

        // Transfer all items from this transfer
        foreach ($items as $transferItem) {
            TransferredItem::create([
                'item_id' => $transferItem->id,
                'transfer_to' => $request->transfer_to,
                'name_designation' => $request->name_designation,
                'position_intended_transfer' => $request->position_intended_transfer,
                'designated_office' => $request->designated_office,
                'designated_office_name' => $request->designated_office_name,
                'position_intended_office' => $request->position_intended_office,
                'transferred_at' => Carbon::now('Asia/Manila')
            ]);
        }

        ActivityLogController::log(
            'Transfer Items',
            "Transferred all items from transfer #{$item->transfer_id} to {$request->transfer_to}"
        );

        return redirect()->route('transfer')->with('success', 'All items have been transferred successfully!');
    }
    public function transferred()
    {
        // Get all transferred items with their related item data
        $transferredItems = TransferredItem::with(['item' => function($query) {
                $query->with('transfer');
            }])
            ->orderBy('transferred_at', 'desc')
            ->get()
            ->unique('item.transfer_id') // Group by transfer_id after getting all items
            ->values(); // Re-index the collection

        return view('transferred', compact('transferredItems'));
    }



    public function show(Transfer $transfer)
    {
        $transfer->load('items');
        return view('show', compact('transfer'));
    }
    public function getTransferredItems($transfer_id)
    {
        $transferredItems = TransferredItem::with('item')
            ->whereHas('item', function ($query) use ($transfer_id) {
                $query->where('transfer_id', $transfer_id);
            })
            ->get();

        if ($transferredItems->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($transferredItems->map(function ($transferred) {
            return [
                'qty' => $transferred->item->qty,
                'description' => $transferred->item->description,
                'date_purchase' => Carbon::parse($transferred->item->date_purchase)->format('F j, Y, g:i A'),
                'property_no' => $transferred->item->property_no,
                'classification_no' => $transferred->item->classification_no,
                'unit' => $transferred->item->unit,
                'total_value' => $transferred->item->total_value,
                'transfer_to' => $transferred->transfer_to,
                'name_designation' => $transferred->name_designation,
                'position_intended_transfer' => $transferred->position_intended_transfer,
                'designated_office' => $transferred->designated_office,
                'designated_office_name' => $transferred->designated_office_name,
                'position_intended_office' => $transferred->position_intended_office
            ];
        }));
    }


    public function showTransferred(Transfer $transfer)
    {
        $transfer->load(['items' => function($query) {
            $query->whereHas('transferredItem');
        }]);
        return view('transferred-show', compact('transfer'));
    }

    public function edit(Transfer $transfer)
    {
        $transfer->load('items');
        return view('edit', compact('transfer'));
    }

    public function editTransferred(Transfer $transfer)
    {
        $transfer->load(['items' => function($query) {
            $query->with('transferredItem');
        }]);
        return view('transferred-edit', compact('transfer'));
    }

    public function update(Request $request, Transfer $transfer)
    {
        $request->validate([
            'items.*.qty' => 'required|numeric',
            'items.*.description' => 'required|string',
            'items.*.date_purchase' => 'required|date',
            'items.*.property_no' => 'nullable|string',
            'items.*.classification_no' => 'nullable|string',
            'items.*.unit' => 'required|string',
            'items.*.total_value' => 'required|numeric',
            'items.*.transfer_to' => 'required|string',
            'items.*.name_designation' => 'required|string',
            'items.*.position_intended_transfer' => 'required|string',
            'items.*.designated_office' => 'required|string',
            'items.*.designated_office_name' => 'required|string',
            'items.*.position_intended_office' => 'required|string',
            'new_items.*.qty' => 'nullable|numeric',
            'new_items.*.description' => 'nullable|string',
            'new_items.*.date_purchase' => 'nullable|date',
            'new_items.*.property_no' => 'nullable|string',
            'new_items.*.classification_no' => 'nullable|string',
            'new_items.*.unit' => 'nullable|string',
            'new_items.*.total_value' => 'nullable|numeric',
            'new_items.*.transfer_to' => 'nullable|string',
            'new_items.*.name_designation' => 'nullable|string',
            'new_items.*.position_intended_transfer' => 'nullable|string',
            'new_items.*.designated_office' => 'nullable|string',
            'new_items.*.designated_office_name' => 'nullable|string',
            'new_items.*.position_intended_office' => 'nullable|string',
        ]);

        $deletedItems = [];
        $updatedItems = [];
        $newItems = [];
        $transferChanges = [];

        // Handle deleted items
        if ($request->has('deleted_items')) {
            foreach ($request->deleted_items as $itemId) {
                $item = Item::find($itemId);
                if ($item) {
                    $deletedItems[] = "Deleted Item #{$item->id}";
                    $item->delete();
                }
            }
        }

        // Update existing items
        if ($request->has('items')) {
            foreach ($request->items as $id => $itemData) {
                $item = Item::find($id);
                if ($item) {
                    $oldValues = $item->getOriginal();
                    $oldTransferredValues = $item->transferredItem ? $item->transferredItem->getOriginal() : null;

                    // Update item data
                    $item->update([
                        'qty' => $itemData['qty'],
                        'description' => $itemData['description'],
                        'date_purchase' => $itemData['date_purchase'],
                        'property_no' => $itemData['property_no'],
                        'classification_no' => $itemData['classification_no'],
                        'unit' => $itemData['unit'],
                        'total_value' => $itemData['total_value'],
                    ]);

                    // Update or create transferred item data
                    if ($item->transferredItem) {
                        $transferredItem = $item->transferredItem;
                        $transferredItem->update([
                            'transfer_to' => $itemData['transfer_to'],
                            'name_designation' => $itemData['name_designation'],
                            'position_intended_transfer' => $itemData['position_intended_transfer'],
                            'designated_office' => $itemData['designated_office'],
                            'designated_office_name' => $itemData['designated_office_name'],
                            'position_intended_office' => $itemData['position_intended_office'],
                            'transferred_at' => Carbon::now('Asia/Manila')
                        ]);
                    } else {
                        TransferredItem::create([
                            'item_id' => $item->id,
                            'transfer_to' => $itemData['transfer_to'],
                            'name_designation' => $itemData['name_designation'],
                            'position_intended_transfer' => $itemData['position_intended_transfer'],
                            'designated_office' => $itemData['designated_office'],
                            'designated_office_name' => $itemData['designated_office_name'],
                            'position_intended_office' => $itemData['position_intended_office'],
                            'transferred_at' => now(),
                        ]);
                    }

                    $itemChanges = [];
                    $fieldsToTrack = ['qty', 'description', 'date_purchase', 'property_no', 'classification_no', 'unit', 'total_value'];

                    foreach ($fieldsToTrack as $field) {
                        if ($oldValues[$field] != $item->$field) {
                            $old = $oldValues[$field];
                            $new = $item->$field;
                            $fieldName = ucwords(str_replace('_', ' ', $field));

                            $itemChanges[] = "{$fieldName} from <strong>{$old}</strong> to <strong>{$new}</strong>";
                        }
                    }

                    if (!empty($itemChanges)) {
                        $updatedItems[] = "Item #{$item->id}:<br>" . implode("<br>", $itemChanges);
                    }
                }
            }
        }

        // Add new items
        if ($request->has('new_items')) {
            foreach ($request->new_items as $newItemData) {
                if (!empty(array_filter($newItemData))) {
                    $item = $transfer->items()->create([
                        'qty' => $newItemData['qty'],
                        'description' => $newItemData['description'],
                        'date_purchase' => $newItemData['date_purchase'],
                        'property_no' => $newItemData['property_no'],
                        'classification_no' => $newItemData['classification_no'],
                        'unit' => $newItemData['unit'],
                        'total_value' => $newItemData['total_value'],
                    ]);

                    TransferredItem::create([
                        'item_id' => $item->id,
                        'transfer_to' => $newItemData['transfer_to'],
                        'name_designation' => $newItemData['name_designation'],
                        'position_intended_transfer' => $newItemData['position_intended_transfer'],
                        'designated_office' => $newItemData['designated_office'],
                        'designated_office_name' => $newItemData['designated_office_name'],
                        'position_intended_office' => $newItemData['position_intended_office'],
                        'transferred_at' => now(),
                    ]);

                    $newItems[] =
                        "Qty: {$item->qty}<br>" .
                        "Description: {$item->description}<br>" .
                        "Date Purchase: " . \Carbon\Carbon::parse($item->date_purchase)->format('m/d/Y') . "<br>" .
                        "Property No: {$item->property_no}<br>" .
                        "Classification No: {$item->classification_no}<br>" .
                        "Unit: {$item->unit}<br>" .
                        "Total Value: {$item->total_value}<br>" .
                        "Transferred To: {$newItemData['transfer_to']}<br>" .
                        "Name/Designation: {$newItemData['name_designation']}<br>" .
                        "Position/Intended Transfer: {$newItemData['position_intended_transfer']}<br>" .
                        "Designated Office: {$newItemData['designated_office']}<br>" .
                        "Designated Office Name: {$newItemData['designated_office_name']}<br>" .
                        "Position/Intended Office: {$newItemData['position_intended_office']}";
                }
            }
        }

        $logMessages = [];
        if (!empty($deletedItems)) {
            $logMessages[] = "Deleted items:<br><br>" . implode("<br><br>", $deletedItems);
        }
        if (!empty($updatedItems)) {
            $logMessages[] = "Updated items:<br><br>" . implode("<br><br>", $updatedItems);
        }
        if (!empty($transferChanges)) {
            $logMessages[] = "Transfer changes:<br><br>" . implode("<br><br>", $transferChanges);
        }
        if (!empty($newItems)) {
            $logMessages[] = "Added new items:<br><br>" . implode("<br><br>", $newItems);
        }

        if (!empty($logMessages)) {
            ActivityLogController::log(
                'Update Transfer',
                "Changes in transfer #{$transfer->id}:<br><br>" . implode("<br><br>", $logMessages)
            );
        }

        return redirect()->route('transferred')->with('success', 'Items updated successfully!');
    }

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

            $itemDescriptions[] = "{$item->qty} {$item->unit} of {$item->description} (Property #: {$item->property_no})";
        }

        ActivityLogController::log(
            'Create Transfer',
            "Created new transfer #{$transfer->id} with items:\n- " . implode("\n- ", $itemDescriptions)
        );

        return redirect()->route('additem')->with('success', 'Item added successfully!');
    }

    public function destroy(Transfer $transfer, Request $request)
    {
        $deletedItems = $transfer->items->map(function($item) {
            return "Deleted Item #{$item->id}";
        })->implode('<br>');

        $transfer->items()->delete();
        $transfer->delete();

        ActivityLogController::log(
            'Delete Transfer',
            "Deleted transfer #{$transfer->id} and its items:<br><br>" . $deletedItems
        );

        // Get the previous URL
        $previousUrl = url()->previous();

        // Check if the request came from the transferred page
        if (str_contains($previousUrl, '/transferred')) {
            return redirect()->route('transferred')->with('success', 'Item deleted successfully!');
        }

        // Default redirect to transfer page
        return redirect()->route('transfer')->with('success', 'Item deleted successfully!');
    }
}
