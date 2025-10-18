<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $item1 = Item::create([
            'name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '良好',
            'user_id' => 1,
        ]);

        $item2 = Item::create([
            'name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'user_id' => 1,
        ]);


         $item3 = Item::create([
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり',
            'user_id' => 1,
        ]);

         $item4 = Item::create([
            'name' => '革靴',
            'price' => 4000,
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い',
            'user_id' => 1,
        ]);
        
         $item5 = Item::create([
            'name' => 'ノートPC',
            'price' => 45000,
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '良好',
            'user_id' => 1,
        ]);
        
         $item6 = Item::create([
            'name' => 'マイク',
            'price' => 8000,
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし',
            'user_id' => 1,
        ]);
        
         $item7 = Item::create([
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり',
            'user_id' => 1,
        ]);
        
         $item8 = Item::create([
            'name' => 'タンブラー',
            'price' => 500,
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い',
            'user_id' => 1,
        ]);
        
         $item9 = Item::create([
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好',
            'user_id' => 1,
        ]);
        
         $item10 = Item::create([
            'name' => 'メイクセット',
            'price' => 2500,
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '目立った傷や汚れなし',
            'user_id' => 1,
        ]);

        $item1->categories()->attach([1, 5]);
        $item2->categories()->attach([2, 3]);
        $item3->categories()->attach([10]);
        $item4->categories()->attach([1, 2]);
        $item5->categories()->attach([2]);
        $item6->categories()->attach([2]);
        $item7->categories()->attach([1, 4]);
        $item8->categories()->attach([3, 10]);
        $item9->categories()->attach([3, 10, 11]);
        $item10->categories()->attach([1, 4, 6]);

    }
}
