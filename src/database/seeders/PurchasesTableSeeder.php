<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchasesTableSeeder extends Seeder
{
    public function run(): void
    {
        // user2 が user1の商品を購入
        Purchase::create([
            'user_id' => 2,
            'item_id' => 1,
            'payment_method' => 'convenience',
            'postcode' => '253-0051',
            'zipcode' => '253-0051',
            'address' => '神奈川県横浜市',
            'building' => 'テストビル101',
        ]);

        Purchase::create([
            'user_id' => 2,
            'item_id' => 2,
            'payment_method' => 'credit',
            'postcode' => '253-0051',
            'zipcode' => '253-0051',
            'address' => '神奈川県茅ヶ崎市',
            'building' => 'テストビル102',
        ]);

        // user1 が user2の商品を購入
        Purchase::create([
            'user_id' => 1,
            'item_id' => 6,
            'payment_method' => 'convenience',
            'postcode' => '253-0052',
            'zipcode' => '253-0052',
            'address' => '東京都',
            'building' => 'テストビル201',
        ]);
    }
}