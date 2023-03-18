<?php

namespace App\Http\Controllers;

use App\Models\IngredienteType;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Ingrediente;
use App\Models\Preset;
use App\Models\BottleSize;
use Cart;

class IngredienteController extends Controller
{
    public function getIngredientsList(Request $request)
    {
        $ingredientsList = Ingrediente::all();
        return response()->json(['ingredientsList' => $ingredientsList]);
    }
    public function getLiquidList(Request $request)
    {
        $ingredientsList = Ingrediente::where('type', IngredienteType::LIQUID)->get();
        return response()->json(['ingredientsList' => $ingredientsList]);
    }
    public function showUpdateField(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::findOrFail($ingredienteID);
        return response()->json(['ingrediente' => $ingrediente]);
    }

    public function create(){
        return view('welcome');
    }

    public function store(Request $request)
    {
        $ingrediente = new Ingrediente;
        $this->storeOrUpdateIngrediente($request, $ingrediente);
    }
    public function updateIngrediente(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::find($ingredienteID);
        $this->storeOrUpdateIngrediente($request, $ingrediente);
    }
    public function storeOrUpdateIngrediente(Request $request, Ingrediente $ingrediente)
    { 
        if ($request->name != null) {
            $ingrediente->name = $request->name;
        }
        if ($request->amount != null) {
            $ingrediente->amount = $request->amount;
        }
        if ($request->price != null) {
            $ingrediente->price = $request->price;
        }
        if ($request->type != null) {
            $ingrediente->type = $request->type;
        }
        if ($request->hasfile('file')) {
            $request->validate([
                'file' => ['required', 'image'],
            ]);
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/piece/', $filename);
            $ingrediente->image = $filename;
        }
        $ingrediente->save();
    }

    public function deleteIngediengte(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::find($ingredienteID);
        $ingrediente->delete($ingrediente->id);
    }

    public function checkPreset(Request $request, $name)
    {
        Cart::destroy();
        $preset = Preset::where('name', $name)->first();
        $bottle = BottleSize::findOrFail($preset->bottle_id);
        $request->session()->put('bottle', $bottle);
        $ingredients = $preset->ingredients;
        foreach ($ingredients as $ingredient) {
            $this->addToCart($ingredient, $ingredient->pivot->quantity);
        }
        return response()->json(['ingrediente' => $preset]);
    }

    public function deleteUserPreset(Request $request, $name)
    {
        $preset = Preset::where('name', $name)->first();
        $preset->delete($preset->id);
    }

    public function storeAsPreset(Request $request)
    {
        $name = $request->input('name');
        if (!Auth::check()) { 
            return response()->json(['auth' => false]);
        }
        $user = Auth::user();
        $userId = $user->id;
        $bottle = $request->session()->get('bottle');
        $preset = new Preset(['name' => $name, 'user_id' => $userId, 'bottle_id' => $bottle->id]);
        $preset->save();
        foreach (Cart::content() as $item) {
            $ingredients[$item->id] = ['quantity' => $item->qty]; 
        }

        $preset->ingredients()->attach($ingredients);
      
       
        return response()->json(['ingrediente' => $preset]);
    }


    private function addToCart($ingrediente, $amount){
        Cart::add([
            'id' => $ingrediente->id,
            'name' => $ingrediente->name,
            'qty' => $amount,
            'price' => $ingrediente->price,
            'options' => [
                'image' => $ingrediente->image,
                'type' =>  $ingrediente->type,
            ],
        ]);
    }


    public function getUserPresets()
    {
        if (!Auth::check()) { 
            return response()->json(['auth' => false]);
        }
        $user = Auth::user();
        $userPresets = Preset::where('user_id', $user->id)->pluck('name');
        return response()->json(['userPresets' => $userPresets]);
    }



}