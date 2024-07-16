<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lastName' => $this->faker->lastName,
            'firstName' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // You can replace 'password' with any default password you want
            'email_verified_at' => now(),
            'role' => $this->faker->randomElement(UserRole::getValues()),
            'profile_image' => null,
            'address' => $this->faker->streetName,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'dob' => $this->faker->date,
            'phone_number' => $this->faker->phoneNumber,
            'gender' => 0,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
