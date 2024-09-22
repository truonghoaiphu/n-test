<?php

namespace App\Services;

use App\Services\ItemStrategy\AppleAirPodsStrategy;
use App\Services\ItemStrategy\SamsungGalaxyS23Strategy;
use App\Services\ItemStrategy\XiaomiRedmiNote13Strategy;
use App\Services\ItemStrategy\DefaultItemStrategy;

class ItemStrategyFactory
{
    public function getStrategy($item)
    {
        switch ($item->name) {
            case 'Apple AirPods':
                return new AppleAirPodsStrategy();
            case 'Samsung Galaxy S23':
                return new SamsungGalaxyS23Strategy();
            case 'Xiaomi Redmi Note 13':
                return new XiaomiRedmiNote13Strategy();
            default:
                return new DefaultItemStrategy();
        }
    }
}
