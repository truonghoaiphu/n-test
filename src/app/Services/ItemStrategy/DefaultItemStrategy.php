<?php

namespace App\Services\ItemStrategy;

class DefaultItemStrategy implements ItemStrategy
{
    public function updateQuality($item): void
    {
        if ($item->quality > 0) {
            $item->quality--;
        }
        $item->sellIn--;

        if ($item->sellIn < 0 && $item->quality > 0) {
            $item->quality--;
        }
    }
}
