<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use App\Services\InventoryService;

class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Items from API';

    /**
     * InventoryService instance
     *
     * @var InventoryService
     */
    protected $inventoryService;

    /**
     * Create a new command instance.
     *
     * @param InventoryService $inventoryService
     */
    public function __construct(InventoryService $inventoryService)
    {
        parent::__construct();
        $this->inventoryService = $inventoryService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://api.restful-api.dev/objects');

        if ($response->successful()) {
            $itemsData = $response->json();

            $items = [];

            foreach ($itemsData as $itemData) {
                $existingItem = Item::where('name', $itemData['name'])->first();
                if ($existingItem) {
                    $this->inventoryService->updateQuality($existingItem);
                } else {
                    $newItem = Item::create([
                        'name' => $itemData['name'],
                        'sellIn' => 1,
                        'quality' => 1,
                    ]);

                    $items[] = $newItem;

                    $this->info("Imported new item: {$newItem->name}");
                }

                foreach ($items as $item) {
                    $item->save();
                    $this->info("Updated item: {$item->name}, Quality: {$item->quality}, SellIn: {$item->sellIn}");
                }
            }
        } else {
            $this->error('Failed to fetch items from API.');
        }

        return 0;
    }
}
