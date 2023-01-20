<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;
use App\Models\IngredienteType;

class GateController extends Controller
{
    public function show()
    {
        $zutaten = Ingrediente::where('type', IngredienteType::FRUITS)->get();

        return view('dashboard', compact('zutaten'));

    }
    public function showVeggieEmployee(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::VEGETABLES)->get();

        return view('dashboard', compact('zutaten'));

    }
    public function showLiquidEmployee(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::LIQUID)->get();

        return view('dashboard', compact('zutaten'));
    }
}
