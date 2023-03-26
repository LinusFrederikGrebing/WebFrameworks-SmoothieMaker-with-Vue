<?php

namespace App\Http\Controllers;

use App\Models\IngredienteType;
use Illuminate\Http\Request;
use App\Models\Ingrediente;

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
        return view('index');
    }

    public function store(Request $request)
    {
        $ingrediente = new Ingrediente;
        $this->storeOrUpdateIngrediente($request, $ingrediente);
        return response()->json(['ingredienteId' => $ingrediente->id]);
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
}