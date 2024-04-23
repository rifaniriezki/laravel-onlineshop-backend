<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Rifani Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('rifaninoer')
        // ]);
        Category::factory(4)->create();
        Product::factory(20)->create();

        $this->call([
            UserSeeder::class,
        ]);
    }
}
