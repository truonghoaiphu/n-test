<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'name' => 'Apple AirPods',
            'sellIn' => 10,
            'quality' => 20
        ]);

        Item::create([
            'name' => 'Apple iPad Air',
            'sellIn' => 5,
            'quality' => 30
        ]);

        Item::create([
            'name' => 'Samsung Galaxy S23',
            'sellIn' => 0,
            'quality' => 80
        ]);

        Item::create([
            'name' => 'Xiaomi Redmi Note 13',
            'sellIn' => 15,
            'quality' => 25
        ]);
    }
}