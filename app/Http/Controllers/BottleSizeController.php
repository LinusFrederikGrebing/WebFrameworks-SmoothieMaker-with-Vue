<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BottleSize;
use Cart;

class BottleSizeController extends Controller
{
    // returns all instances of the BottleSize
    public function showBottleSizes()
    {
        // deletes previous compositions to avoid changing a composition of, for example, 10 ingredients to a composition of, for example, 5 ingredients.
        Cart::destroy();
        $bottles = BottleSize::all();
        return response()->json(['bottles' => $bottles ]);
    }
    // saves the selected BottleSize in the session, since our shopping cart also runs through the session.
    public function storeBottleSize(Request $request, $bottleID)
    { 
        $bottle = BottleSize::findOrFail($bottleID);
        $request->session()->put('bottle', $bottle);
        return response()->json([]);
    }
}
