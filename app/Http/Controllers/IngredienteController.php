<?php

namespace App\Http\Controllers;

use App\Models\IngredienteType;
use Illuminate\Http\Request;
use App\Models\Ingrediente;

class IngredienteController extends Controller
{
    // we treat liquid a little differently in the ingredient table because this ingredient can only appear once
    // return all ingredients as a JSON object
    public function getIngredientsList(Request $request)
    {
        $ingredientsList = Ingrediente::all();
        return response()->json(['ingredientsList' => $ingredientsList]);
    }
    // return just the liquid ingredients as a JSON object
    public function getLiquidList(Request $request)
    {
        $ingredientsList = Ingrediente::where('type', IngredienteType::LIQUID)->get();
        return response()->json(['ingredientsList' => $ingredientsList]);
    }
    // return the ingredient to be updated in the form
    public function showUpdateField(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::findOrFail($ingredienteID);
        return response()->json(['ingrediente' => $ingrediente]);
    }

    // create a new ingredient instance and add the information from the request
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image'],
        ]);
        $ingrediente = new Ingrediente;
        $this->storeOrUpdateIngrediente($request, $ingrediente);
        return response()->json(['ingredienteId' => $ingrediente->id]);
    }
    // gets a reference to the ingredient instance and adds the information from the request
    public function updateIngrediente(Request $request, $ingredienteID)
    {
        $request->validate([
            'image' => ['image'],
        ]);
        $ingrediente = Ingrediente::find($ingredienteID);
        $this->storeOrUpdateIngrediente($request, $ingrediente);
    }
    // The file must be specially considered and validated. When creating the ingredient, sending without an entry is prevented in the frontend. 
    // There doesn't have to be any change in the case of updates.
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
    // Deletes the passed ingredient from the database
    public function deleteIngediengte(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::find($ingredienteID);
        $ingrediente->delete($ingrediente->id);
    }
}