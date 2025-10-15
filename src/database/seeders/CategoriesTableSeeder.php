<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       public function run(): void
   {
       DB::table('categories')->insert([
           ['name' => 'ファッション', 'parent_id' => null],
           ['name' => '家電', 'parent_id' => null],
           ['name' => 'インテリア', 'parent_id' => null],
           ['name' => 'レディース', 'parent_id' => null],
           ['name' => 'メンズ', 'parent_id' => null],
           ['name' => 'コスメ', 'parent_id' => null],
           ['name' => '本', 'parent_id' => null],
           ['name' => 'ゲーム', 'parent_id' => null],
           ['name' => 'スポーツ', 'parent_id' => null],
           ['name' => 'キッチン', 'parent_id' => null],
           ['name' => 'ハンドメイド', 'parent_id' => null],
           ['name' => 'アクセサリー', 'parent_id' => null],
           ['name' => 'おもちゃ', 'parent_id' => null],
           ['name' => 'ベビー・キッズ', 'parent_id' => null],
        ]);
    }
}

