<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BottleSize;

class BottleSizeController extends Controller
{
    public function showBottleSizes()
    {
        $bottles = BottleSize::all();
        return response()->json(['bottles' => $bottles ]);
    }

    public function showInhalt(Request $request, $bottleID)
    { 
        $bottle = BottleSize::findOrFail($bottleID);
        $request->session()->put('bottle', $bottle);
        $bottleSes = $request->session()->get('bottle');
        return response()->json(['bottles' => $bottleSes  ]);
    }
}
