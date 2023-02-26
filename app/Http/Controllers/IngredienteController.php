<?php

namespace App\Http\Controllers;

use App\Models\IngredienteType;

use Illuminate\Http\Request;
use App\Models\Ingrediente;

class IngredienteController extends Controller
{
    public function getFruits(Request $request)
    {
        $ingrediente = Ingrediente::where('type', IngredienteType::FRUITS)->get();
        return response()->json(['ingrediente' => $ingrediente]);
    }

    public function getVegetables(Request $request)
    {
        $ingrediente = Ingrediente::where('type', IngredienteType::VEGETABLES)->get();
        return response()->json(['ingrediente' => $ingrediente]);
    }

    public function getLiquid(Request $request)
    {
        $ingrediente = Ingrediente::where('type', IngredienteType::LIQUID)->get();
        return response()->json(['ingrediente' => $ingrediente]);
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
        $ingrediente = Ingrediente::find($ingredienteID);
        $ingrediente->delete($ingrediente->id);
    }

    public function updateIngrediente(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::find($ingredienteID);
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
}