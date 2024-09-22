<?php

namespace App\Services\ItemStrategy;

interface ItemStrategy
{
    public function updateQuality($item): void;
}
