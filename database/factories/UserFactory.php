<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('111'),
            'phone' => '+380' . fake()->numberBetween(111111111, 999999999),
            'position_id' => fake()->numberBetween(1, 5),
            'photo' => "http://api-test/images/users/5b977ba" . fake()->lexify('????????') . ".jpg" ,
            'registration_timestamp' => time(),
        ];
    }

    public function adminAccount()
    {
        return $this->state([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('111'),
            'phone' => '+380111111111',
            'position_id' => fake()->numberBetween(1, 5),
            'photo' => "http://api-test/images/users/5b977ba" . fake()->lexify('????????') . ".jpg" ,
            'registration_timestamp' => time(),
        ]);
    }
}
