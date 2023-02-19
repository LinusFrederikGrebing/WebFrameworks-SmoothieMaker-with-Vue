<?php

namespace App\Http\Controllers;
use App\Models\IngredienteType;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Cart;
use App\Models\BottleSize;


class BottleSizeController extends Controller
{
    public function showBottleSizes()
    {
        $bottles = BottleSize::all();

        return view('steps/step1ChooseSize', compact('bottles'));
    }

    public function showInhalt(Request $request, $bottleID)
    { 
        Cart::destroy();
        
        $bottle = BottleSize::findOrFail($bottleID);
        $request->session()->put('bottle', $bottle);

        $zutaten = Ingrediente::where('type', IngredienteType::FRUITS)->get();
      
        return view('steps/step2ChooseIngrediente', compact('zutaten'));
    }

}
