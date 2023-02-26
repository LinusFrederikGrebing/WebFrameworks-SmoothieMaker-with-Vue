<?php

namespace App\Http\Controllers;

use App\Models\IngredienteType;

use Illuminate\Http\Request;
use App\Models\Ingrediente;
use Alert;

class IngredienteController extends Controller
{

    private $test;
    public function showFruits(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::FRUITS)->get();

        return view('steps/step2ChooseIngrediente', compact('zutaten'));

    }
    public function getFruits(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::FRUITS)->get();
        return response()->json(['zutaten' => $zutaten]);
    }
    public function getVegetables(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::VEGETABLES)->get();
        return response()->json(['zutaten' => $zutaten]);
    }
    public function getLiquid(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::LIQUID)->get();
        return response()->json(['zutaten' => $zutaten]);
    }


    public function showVeggie(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::VEGETABLES)->get();

        return view('steps/step2ChooseIngrediente', compact('zutaten'));

    }
    public function showLiquids(Request $request)
    {
        $zutaten = Ingrediente::where('type', IngredienteType::LIQUID)->get();

        return view('steps/step2ChooseIngrediente', compact('zutaten'));
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
            $file->move('images/', $filename);
            $ingrediente->image = $filename;
        }

        $ingrediente->save();
    }


    public function deleteIngediengte(Request $request, $ingredienteID)
    {
        $zutat = Ingrediente::find($ingredienteID);
        $zutat->delete($zutat->id);
    }

    public function updateIngrediente(Request $request, $ingredienteID)
    {
        $zutat = Ingrediente::find($ingredienteID);

        if ($request->name != null) {
            $zutat->name = $request->name;
        }
        if ($request->amount != null) {
            $zutat->amount = $request->amount;
        }
        if ($request->price != null) {
            $zutat->price = $request->price;
        }
        if ($request->type != null) {
            $zutat->type = $request->type;
        }


        if ($request->hasfile('file')) {
            $request->validate([
                'file' => ['required', 'image'],
            ]);
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);
            $zutat->image = $filename;
        }

        $zutat->save();
    }
}