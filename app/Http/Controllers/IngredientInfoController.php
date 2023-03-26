<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IngredientInfo;
use App\Models\Ingrediente;

class IngredientInfoController extends Controller
{
    // return the ingredient information for a specific ingredient
    public function getIngredientInfo(Request $request, $id)
    {
        $ingredientInfo = IngredientInfo::where('ingrediente_id', $id)->first();
        return response()->json(['ingredientInfo' => $ingredientInfo]);
    }
    // get the ingredient for which information should be created
    public function getIngredient(Request $request, $id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        return response()->json(['ingrediente' => $ingrediente]);
    }
    // return all important information for the update form -> i.e. the ingredient to which the ingredient information belongs and the current ingredient information
    public function showUpdateField(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::findOrFail($ingredienteID);
        $ingredientInfo = IngredientInfo::where('ingrediente_id', $ingredienteID)->first();
        return response()->json(['ingrediente' => $ingrediente, 'ingredientInfo' => $ingredientInfo]);
    }
    // create an IngredientInfo instance and fill it with the data from the request
    public function storeIngredientInfo(Request $request, $ingredienteID)
    {
        $ingredienteInfo = new IngredientInfo;
        $ingredienteInfo->ingrediente_id = $ingredienteID;
        $this->storeOrUpdateIngrediente($request, $ingredienteInfo); 
    }
    // get a reference to the existing IngredientInfo instance and update it with the data from the request
    public function updateIngrediente(Request $request, $ingredienteID)
    {
        $ingredientInfo = IngredientInfo::where('ingrediente_id', $ingredienteID)->first();
        $this->storeOrUpdateIngrediente($request, $ingredientInfo);
    }
    // the ingredient information can be empty. If nothing was passed, just write an empty string to the database
    public function storeOrUpdateIngrediente(Request $request, IngredientInfo $ingrediente)
    { 
        $ingrediente->info = $request->info ? $request->info : '';
        $ingrediente->energie = $request->energie ? $request->energie : '';
        $ingrediente->fett = $request->fett ? $request->fett : '';
        $ingrediente->fattyacids = $request->fattyacids ? $request->fattyacids : '';
        $ingrediente->carbohydrates = $request->carbohydrates ? $request->carbohydrates : '';
        $ingrediente->fruitscarbohydrates = $request->fruitscarbohydrates ? $request->fruitscarbohydrates : '';
        $ingrediente->protein = $request->protein ? $request->protein : '';
        $ingrediente->salt = $request->salt ? $request->salt : '';
        $ingrediente->save();
    }
}
