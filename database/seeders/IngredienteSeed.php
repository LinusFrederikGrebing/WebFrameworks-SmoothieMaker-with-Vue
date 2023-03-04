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
        /* FRUITS */
        Ingrediente::factory()->create([
            'name' => 'Banane',
            'price' => 0.8,
            'image' => "banane.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Kirsche',
            'price' => 0.7,
            'image' => "cherry.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "kirsche-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Trauben',
            'price' => 0.4,
            'image' => "grapes.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "traube-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Erdbeere',
            'price' => 0.8,
            'image' => "strawberry.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "erdbeere-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Mango',
            'price' => 0.8,
            'image' => "mango.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "mango-piece.png",
        ]);

        Ingrediente::factory()->create([
            'name' => 'Apfel',
            'price' => 0.4,
            'image' => "apple.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "apfel-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Granatapfel',
            'price' => 0.7,
            'image' => "pomegranate.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "granatapfel-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Orange',
            'price' => 0.5,
            'image' => "orange.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "orange-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Pfirsich',
            'price' => 0.5,
            'image' => "peach.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "pfirsich-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Ananas',
            'price' => 0.5,
            'image' => "pineapple.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "ananas-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Kiwi',
            'price' => 0.4,
            'image' => "kiwi.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "kiwi-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Zitrone',
            'price' => 0.3,
            'image' => "lemon.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "zitrone-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Blaubeere',
            'price' => 0.7,
            'image' => "blueberry.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "blaubeere-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Himbeere',
            'price' => 0.9,
            'image' => "raspberry.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "himbeere-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Feige',
            'price' => 0.7,
            'image' => "fig.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "feige-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Litschi',
            'price' => 1.0,
            'image' => "lychee.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "litschi-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Kokosnuss',
            'price' => 0.9,
            'image' => "coconut.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "kokosnuss-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Avocado',
            'price' => 0.4,
            'image' => "avocado.svg",
            'type' => IngredienteType::FRUITS,
            'piece' => "avocado-piece.png",
        ]);

        /* VEGETABLES */
        Ingrediente::factory()->create([
            'name' => 'Brokkoli',
            'price' => 0.5,
            'image' => "broccoli.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Gurke',
            'price' => 0.3,
            'image' => "gurke.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Karotte',
            'price' => 0.2,
            'image' => "karotte.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Aubergine',
            'price' => 0.6,
            'image' => "aubergine.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Grünkohl',
            'price' => 0.5,
            'image' => "cabbage.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Kürbis',
            'price' => 0.7,
            'image' => "pumpkin.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Rote Beete',
            'price' => 0.6,
            'image' => "beet.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Spinat',
            'price' => 0.3,
            'image' => "spinach.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Zuccini',
            'price' => 0.6,
            'image' => "zuccini.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Tomate',
            'price' => 0.4,
            'image' => "tomate.svg",
            'type' => IngredienteType::VEGETABLES,
            'piece' => "banana-piece.png",
        ]);

        /* LIQUIDS */
        Ingrediente::factory()->create([
            'name' => 'Milch',
            'price' => 1.7,
            'image' => "milch.svg",
            'type' => IngredienteType::LIQUID,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Wasser',
            'price' => 0.2,
            'image' => "milch.svg",
            'type' => IngredienteType::LIQUID,
            'piece' => "banana-piece.png",
        ]);
        Ingrediente::factory()->create([
            'name' => 'Hafermilch',
            'price' => 2.2,
            'image' => "milch.svg",
            'type' => IngredienteType::LIQUID,
            'piece' => "banana-piece.png",
        ]);
    }
}