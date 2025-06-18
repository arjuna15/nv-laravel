<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserModel::factory()->create([
            'villa_id' => 1,
            'username' => 'admin',
            'password' => Hash::make('123'),
            'role_id' => 1,
        ]);
    }

}
