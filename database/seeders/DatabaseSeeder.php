<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
 //       Admin::truncate();
        Store::factory(5)->create();
        Admin::factory(30)->create();
//        $this->call(UserSeeder::class);
      //  $this->call(TruncateSeeder::class);
      //  User::factory()->create([
      //     'name' => 'Test User',
      //     'email' => 'test@example.com',
      // ]);


//        User::factory(2)->create();
        Store::factory(5)->create();
        Category::factory(5)->create();
        Product::factory(100)->create();

    }
}
