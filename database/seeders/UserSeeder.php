<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(9)->create();

        User::factory()->create([
                'name' => 'Rifani Admin2',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('rifaninoer'),
                'phone' => '0811111111',
                'roles' => 'ADMIN'
            ]);
    }
}
