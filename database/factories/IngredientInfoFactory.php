<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'info' => 'Zink, Mangan, Kalium, Magnesium',
            'ingrediente_id' => 35,
            'energie' => "1398kJ / 334 kcal",
            'fett' => "0,7 g/100g",
            'fatty-acids' => "0 g/100g",
            'carbohydrates' => "74,3 g/100g",
            'fruits-carbohydrates' => "64,1 g/100g",
            'protein' => "4,3 g/100g",
            'salt' => "0,01 g/100g",
        ];
    }
}
