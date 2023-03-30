<?php

namespace App\Http\Controllers;

use App\Models\IngredientType;
use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    // we treat liquid a little differently in the ingredient table because this ingredient can only appear once
    // return all ingredients as a JSON object
    public function getIngredientsList(Request $request)
    {
        $ingredientsList = Ingredient::all();
        return response()->json(['ingredientsList' => $ingredientsList]);
    }
    // return just the liquid ingredients as a JSON object
    public function getLiquidList(Request $request)
    {
        $ingredientsList = Ingredient::where('type', IngredientType::LIQUID)->get();
        return response()->json(['ingredientsList' => $ingredientsList]);
    }
    // return the ingredient to be updated in the form
    public function showUpdateField(Request $request, $ingredientID)
    {
        $ingredient = Ingredient::findOrFail($ingredientID);
        return response()->json(['ingredient' => $ingredient]);
    }

    // create a new ingredient instance and add the information from the request
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image'],
        ]);
        $ingredient = new Ingredient;
        $this->storeOrUpdateIngredient($request, $ingredient);
        return response()->json(['ingredientId' => $ingredient->id]);
    }
    // gets a reference to the ingredient instance and adds the information from the request
    public function updateIngredient(Request $request, $ingredientID)
    {
        $request->validate([
            'image' => ['image'],
        ]);
        $ingredient = Ingredient::find($ingredientID);
        $this->storeOrUpdateIngredient($request, $ingredient);
    }
    // The file must be specially considered and validated. When creating the ingredient, sending without an entry is prevented in the frontend. 
    // There doesn't have to be any change in the case of updates.
    public function storeOrUpdateIngredient(Request $request, Ingredient $ingredient)
    { 
        if ($request->name != null) {
            $ingredient->name = $request->name;
        }
        if ($request->amount != null) {
            $ingredient->amount = $request->amount;
        }
        if ($request->price != null) {
            $ingredient->price = $request->price;
        }
        if ($request->type != null) {
            $ingredient->type = $request->type;
        }
        if ($request->hasfile('file')) {
            $request->validate([
                'file' => ['required', 'image'],
            ]);
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/piece/', $filename);
            $ingredient->image = $filename;
        }
        $ingredient->save();
    }
    // Deletes the passed ingredient from the database
    public function deleteIngediengte(Request $request, $ingredientID)
    {
        $ingredient = Ingredient::find($ingredientID);
        $ingredient->delete($ingredient->id);
    }
}