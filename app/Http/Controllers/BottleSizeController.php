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
        return response()->json(['bottles' => $bottles ]);
       // return view('steps/step1ChooseSize', compact('bottles'));
    }

    public function showInhalt(Request $request, $bottleID)
    { 
        //Cart::destroy();
        $bottle = BottleSize::findOrFail($bottleID);
        $request->session()->put('bottle', $bottle);
        $bottleSes = $request->session()->get('bottle');
        return response()->json(['bottles' => $bottleSes  ]);
    }

}
