<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        
            'name' => $this->faker->firstName(10),
            'surnames' => $this->faker->lastName(10).' '.$this->faker->lastName(10),
            'email' => $this->faker->safeEmail,
            'nick' => $this->faker->firstName(10),
            'password' => Hash::make('password'),
            'birth_date' => $this->faker->date,
            
        ];
    }
}
