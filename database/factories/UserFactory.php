<?php

namespace Database\Factories;

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
        $roles = ['super-admin', 'admin', 'doctor', 'patient', 'assistant'];
        return [
            'lastName' => $this->faker->lastName,
            'firstName' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // You can replace 'password' with any default password you want
            'email_verified_at' => now(),
            'role' => $this->faker->randomElement($roles),
            'avatar' => null,
            'city' => $this->faker->city,
            'town' => $this->faker->streetName,
            'dob' => $this->faker->date,
            'phone_number' => $this->faker->phoneNumber,
            'insurance_number' => $this->faker->numerify('##########'),
            'cin_number' => $this->faker->numerify('#########'),
            'speciality' => $this->faker->word,
            'registration_number' => $this->faker->numerify('##########'),
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
