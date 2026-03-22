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
        /**User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);*/

        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
            PurchasesTableSeeder::class,
            TradesTableSeeder::class,
            MessagesTableSeeder::class,
        ]);
    }
}
