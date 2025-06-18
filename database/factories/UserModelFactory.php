<?php

namespace Database\Factories;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserModelFactory extends Factory
{
    protected $model = UserModel::class;

    public function definition(): array
    {
        return [
            'villa_id' => 1,
            'username' => $this->faker->userName,
            'password' => Hash::make('password'),
            'role_id' => 1,
        ];
    }
}

