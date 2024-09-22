<?php

namespace App\Services\ItemStrategy;

class AppleAirPodsStrategy implements ItemStrategy
{
    public function updateQuality($item): void
    {
        if ($item->quality < 50) {
            $item->quality++;

            if ($item->sellIn < 0 && $item->quality < 50) {
                $item->quality++;
            }
        }
        $item->sellIn--;
    }
}
