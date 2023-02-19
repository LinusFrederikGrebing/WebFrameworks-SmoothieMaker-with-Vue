<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IngredienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "NAME",
            'price' => 1.2,
            'amount' => 20,
            'image' => "banane.svg",
            'type' => "fruits"
        ];
    }
}
