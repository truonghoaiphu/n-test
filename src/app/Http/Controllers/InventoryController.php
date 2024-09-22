<?php

namespace App\Http\Controllers;

use App\Services\InventoryService;
use App\Models\Item;
use Exception;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function updateInventory()
    {
        try {
            $items = Item::all();
            foreach ($items as $item) {
                $this->inventoryService->updateQuality($item);
            }

            return response()->json(['message' => 'Inventory updated successfully']);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update inventory',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
