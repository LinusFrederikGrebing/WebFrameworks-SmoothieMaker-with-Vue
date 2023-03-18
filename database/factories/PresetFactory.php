<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Preset;
use App\Models\Ingrediente;

class PresetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null, 
            'bottle_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
