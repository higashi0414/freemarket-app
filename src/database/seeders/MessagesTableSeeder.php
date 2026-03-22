<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;

class MessagesTableSeeder extends Seeder
{
    public function run(): void
    {
        Message::create([
            'trade_id' => 1,
            'user_id' => 2,
            'message' => '購入しました！よろしくお願いします！',
            'image' => null,
        ]);

        Message::create([
            'trade_id' => 1,
            'user_id' => 1,
            'message' => 'ありがとうございます！すぐ発送します！',
            'image' => null,
        ]);

        Message::create([
            'trade_id' => 2,
            'user_id' => 2,
            'message' => 'こちらの商品まだありますか？',
            'image' => null,
        ]);

        Message::create([
            'trade_id' => 2,
            'user_id' => 1,
            'message' => 'はい、まだあります！',
            'image' => null,
        ]);

        Message::create([
            'trade_id' => 3,
            'user_id' => 1,
            'message' => '購入させていただきました！',
            'image' => null,
        ]);

        Message::create([
            'trade_id' => 3,
            'user_id' => 2,
            'message' => 'ありがとうございます！',
            'image' => null,
        ]);
    }
}