<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Professor>
 */
class ProfessorFactory extends Factory
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
            'center' => $this->faker->name(10),
        ];
    }
}
