<?php

namespace App\Services;

class InventoryService
{
    protected $strategyFactory;

    public function __construct(ItemStrategyFactory $strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }

    public function updateQuality($item)
    {
        $strategy = $this->strategyFactory->getStrategy($item);
        $strategy->updateQuality($item);
    }
}