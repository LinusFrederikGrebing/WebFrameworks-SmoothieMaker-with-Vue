<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BottleSizeFactory extends Factory
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
            'description' => "",
            'amount' => 10,
            'image' => "bottlezizes.svg",
        ];
    }
}
