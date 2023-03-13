<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        
            'name' => $this->faker->name(10),
            'surnames' => $this->faker->name(10).' '.$this->faker->name(10),
            'email' => $this->faker->safeEmail,
            'nick' => $this->faker->name(10),
            'password' => 'password',
            'character_id' => $this->faker->randomElement(["1", "6", "11", "16", "21", "26"]),
            'total_puntuation' => $this->faker->numberBetween(0, 7000),
            'birth_date' => $this->faker->date,
            
        ];
    }
}
