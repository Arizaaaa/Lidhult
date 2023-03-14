<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() { // Tabla predefinida de personajes

        DB::table('characters')->delete();

        $characters = [

            [ 'name' => 'Eze', 'level' => '1', 'link' => '/images/common/Eze1.webp' ],
            [ 'name' => 'Eze', 'level' => '2', 'link' => '/images/common/Eze2.webp' ],
            [ 'name' => 'Eze', 'level' => '3', 'link' => '/images/common/Eze3.webp' ],
            [ 'name' => 'Eze', 'level' => '4', 'link' => '/images/common/Eze4.webp' ],
            [ 'name' => 'Eze', 'level' => '5', 'link' => '/images/common/Eze5.webp' ],
            [ 'name' => 'Vargas', 'level' => '1', 'link' => '/images/common/Vargas1.webp' ],
            [ 'name' => 'Vargas', 'level' => '2', 'link' => '/images/common/Vargas2.webp' ],
            [ 'name' => 'Vargas', 'level' => '3', 'link' => '/images/common/Vargas3.webp' ],
            [ 'name' => 'Vargas', 'level' => '4', 'link' => '/images/common/Vargas4.webp' ],
            [ 'name' => 'Vargas', 'level' => '5', 'link' => '/images/common/Vargas5.webp' ],
            [ 'name' => 'Lance', 'level' => '1', 'link' => '/images/common/Lance1.webp' ],
            [ 'name' => 'Lance', 'level' => '2', 'link' => '/images/common/Lance2.webp' ],
            [ 'name' => 'Lance', 'level' => '3', 'link' => '/images/common/Lance3.webp' ],
            [ 'name' => 'Lance', 'level' => '4', 'link' => '/images/common/Lance4.webp' ],
            [ 'name' => 'Lance', 'level' => '5', 'link' => '/images/common/Lance5.webp' ],
            [ 'name' => 'Selena', 'level' => '1', 'link' => '/images/common/Selena1.webp' ],
            [ 'name' => 'Selena', 'level' => '2', 'link' => '/images/common/Selena2.webp' ],
            [ 'name' => 'Selena', 'level' => '3', 'link' => '/images/common/Selena3.webp' ],
            [ 'name' => 'Selena', 'level' => '4', 'link' => '/images/common/Selena4.webp' ],
            [ 'name' => 'Selena', 'level' => '5', 'link' => '/images/common/Selena5.webp' ],
            [ 'name' => 'Atro', 'level' => '1', 'link' => '/images/common/Atro1.webp' ],
            [ 'name' => 'Atro', 'level' => '2', 'link' => '/images/common/Atro2.webp' ],
            [ 'name' => 'Atro', 'level' => '3', 'link' => '/images/common/Atro3.webp' ],
            [ 'name' => 'Atro', 'level' => '4', 'link' => '/images/common/Atro4.webp' ],
            [ 'name' => 'Atro', 'level' => '5', 'link' => '/images/common/Atro5.webp' ],
            [ 'name' => 'Magress', 'level' => '1', 'link' => '/images/common/Magress1.webp' ],
            [ 'name' => 'Magress', 'level' => '2', 'link' => '/images/common/Magress2.webp' ],
            [ 'name' => 'Magress', 'level' => '3', 'link' => '/images/common/Magress3.webp' ],
            [ 'name' => 'Magress', 'level' => '4', 'link' => '/images/common/Magress4.webp' ],
            [ 'name' => 'Magress', 'level' => '5', 'link' => '/images/common/Magress5.webp' ],
            
        ];

        foreach($characters as $character) {
            Character::create($character);        
        }
    }
}
