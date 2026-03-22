<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trade;

class TradesTableSeeder extends Seeder
{
    public function run(): void
    {

        Trade::create([
            'purchase_id' => 1,
            'item_id' => 1,
            'seller_id' => 1,
            'buyer_id' => 2,
            'status' => 'trading',
        ]);

        Trade::create([
            'purchase_id' => 2,
            'item_id' => 2,
            'seller_id' => 1,
            'buyer_id' => 2,
            'status' => 'trading',
        ]);

        Trade::create([
            'purchase_id' => 3,
            'item_id' => 6,
            'seller_id' => 2,
            'buyer_id' => 1,
            'status' => 'trading',
        ]);
    }
}