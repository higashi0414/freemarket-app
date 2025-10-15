<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
    // 仮ユーザー作成
        User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

    // 他のシーダーを呼び出す
        $this->call([
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
        ]);
    }
}
