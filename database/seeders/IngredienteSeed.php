<?php

namespace Database\Seeders;

use App\Models\IngredienteType;
use Illuminate\Database\Seeder;
use App\Models\Ingrediente;

class IngredienteSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ingrediente::factory()->create([
            'name' => 'Banane',
            'price' => 2.2,
            'image' => "banane.svg",
            'type' => IngredienteType::FRUITS
        ]);
        Ingrediente::factory()->create([
            'name' => 'Brokkoli',
            'price' => 0.5,
            'image' => "brokkoli.svg",
            'type' => IngredienteType::VEGETABLES
        ]);
        Ingrediente::factory()->create([
            'name' => 'Kirsche',
            'price' => 1.7,
            'image' => "cherry.svg",
            'type' => IngredienteType::FRUITS
        ]);
        Ingrediente::factory()->create([
            'name' => 'Trauben',
            'price' => 0.9,
            'image' => "grapes.svg",
            'type' => IngredienteType::FRUITS
        ]);
        Ingrediente::factory()->create([
            'name' => 'Gurke',
            'price' => 0.7,
            'image' => "gurke.svg",
            'type' => IngredienteType::VEGETABLES
        ]);
        Ingrediente::factory()->create([
            'name' => 'Karotte',
            'price' => 2.2,
            'image' => "karotte.svg",
            'type' => IngredienteType::VEGETABLES
        ]);
        Ingrediente::factory()->create([
            'name' => 'Mango',
            'price' => 2.2,
            'image' => "mango.svg",
            'type' => IngredienteType::FRUITS
        ]);
        Ingrediente::factory()->create([
            'name' => 'Milch',
            'price' => 2.2,
            'image' => "milch.svg",
            'type' => IngredienteType::LIQUID
        ]);
        Ingrediente::factory()->create([
            'name' => 'Erdbeere',
            'price' => 2.2,
            'image' => "strawberry.svg",
            'type' => IngredienteType::FRUITS
        ]);
        Ingrediente::factory()->create([
            'name' => 'Tomate',
            'price' => 2.2,
            'image' => "tomate.svg",
            'type' => IngredienteType::VEGETABLES
        ]);
    }
}