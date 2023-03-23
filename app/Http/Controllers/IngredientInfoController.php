<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IngredientInfo;
use App\Models\Ingrediente;

class IngredientInfoController extends Controller
{
    public function getIngredientInfo(Request $request, $id)
    {
        $ingredientInfo = IngredientInfo::where('ingrediente_id', $id)->first();
        return response()->json(['ingredientInfo' => $ingredientInfo]);
    }
    public function showUpdateField(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::findOrFail($ingredienteID);
        $ingredientInfo = IngredientInfo::where('ingrediente_id', $ingredienteID)->first();
        return response()->json(['ingrediente' => $ingrediente, 'ingredientInfo' => $ingredientInfo]);
    }

    public function store(Request $request)
    {
        $ingrediente = new Ingrediente;
        $this->storeOrUpdateIngrediente($request, $ingrediente);
    }
    public function updateIngrediente(Request $request, $ingredienteID)
    {
        $ingredientInfo = IngredientInfo::where('ingrediente_id', $ingredienteID)->first();
        $this->storeOrUpdateIngrediente($request, $ingredientInfo);
    }
    public function storeOrUpdateIngrediente(Request $request, IngredientInfo $ingrediente)
    { 
        if ($request->info != null) {
            $ingrediente->info = $request->info;
        }
        if ($request->energie != null) {
            $ingrediente->energie = $request->energie;
        }
        if ($request->fett != null) {
            $ingrediente->fett = $request->fett;
        }
        if ($request->fattyacids != null) {
            $ingrediente->fattyacids = $request->fattyacids;
        }
        if ($request->carbohydrates != null) {
            $ingrediente->carbohydrates = $request->carbohydrates;
        }
        if ($request->fruitscarbohydrates != null) {
            $ingrediente->fruitscarbohydrates = $request->fruitscarbohydrates;
        }
        if ($request->protein != null) {
            $ingrediente->protein = $request->protein;
        }
        if ($request->salt != null) {
            $ingrediente->salt = $request->salt;
        }
        $ingrediente->save();
    }

}
