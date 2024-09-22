<?php

namespace App\Services\ItemStrategy;

class XiaomiRedmiNote13Strategy implements ItemStrategy
{
    public function updateQuality($item): void
    {
        $item->quality = max($item->quality - 2, 0);
        $item->sellIn--;

        if ($item->sellIn < 0) {
            $item->quality = max($item->quality - 2, 0);
        }
    }
}
