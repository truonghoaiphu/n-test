<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\Services\InventoryService;
use App\Services\ItemStrategyFactory;
use App\Services\ItemStrategy\DefaultItemStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_quality_for_items()
    {
        // Mock the ItemStrategyFactory and the strategy
        $strategyFactory = $this->createMock(ItemStrategyFactory::class);
        $strategy = $this->createMock(DefaultItemStrategy::class);

        $strategyFactory->method('getStrategy')->willReturn($strategy);

        $strategy->expects($this->exactly(2))->method('updateQuality');

        $inventoryService = new InventoryService($strategyFactory);

        $items = Item::factory()->count(2)->create([
            'quality' => 20,
            'sellIn' => 10,
        ]);

        foreach ($items as $item) {
            $inventoryService->updateQuality($item);
        }
    }
}
