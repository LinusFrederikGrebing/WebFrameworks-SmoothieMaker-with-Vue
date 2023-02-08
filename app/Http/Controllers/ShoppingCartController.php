<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\BottleSize;
use App\Models\Ingrediente;
use Alert;
use App\Models\IngredienteType;
class ShoppingCartController extends Controller
{
    public function storeCart(Request $request, $ingredienteID)
    {
        //dd("test");
        $zutat = Ingrediente::find($ingredienteID);
        if ((Cart::count()+$request->amount) <= $request->session()->get('bottle')->amount) {
         Cart::add(
            array(
                'id' => $zutat->id,
                'name' => $zutat->name,
                'qty' => $request->amount,
                'price' => $zutat->price,
                'options' => array('image' => $zutat->image),
            )
         );
         return response()->json(['image' => $zutat->image, 'count' => Cart::count(), 'reqCount' => $request->amount, 'amount' => $request->session()->get('bottle')->amount]);

        // Alert::success('', 'Die Zutat wurde erfolgreich zum Warenkorb hinzugefügt!');
        } 
        /*else {
            Alert::error('', 'Du hast zu viele Zutaten ausgewählt!');
        }*/
       
        // $zutaten = Ingrediente::where('type', IngredienteType::FRUITS)->get();

        // return view('steps/step2ChooseIngrediente', compact('zutaten'));
    }

    public function deleteCart(Request $request, $ingredienteID)
    {
        Cart::remove($ingredienteID);
        return view('steps/step3ShopComponent');
    }

    public function removeAllFromCard(Request $request)
    {
        Cart::destroy();
        Alert::info('', 'Der Warenkorb wurde erfolgreich geleert!');
        return view('steps/step3ShopComponent');
    }


    public function increaseCardQty(Request $request, $ingredienteID)
    {
        if (Cart::count() < $request->session()->get('bottle')->amount) {
            $newqty = Cart::get($ingredienteID)->qty + 1;
            Cart::update($ingredienteID, $newqty); // Will update the quantity
        } else {
            Alert::error('', 'Du hast zu viele Zutaten ausgewählt!');
        }
        return view('steps/step3ShopComponent');
    }

    public function decreaseCardQty(Request $request, $ingredienteID)
    {
        $newqty = Cart::get($ingredienteID)->qty - 1;
        Cart::update($ingredienteID, $newqty); // Will update the quantity

        return view('steps/step3ShopComponent');
    }

    public function showCard(Request $request)
    {
       
        if ($request->session()->get('bottle') == true) {
            $bottle = $request->session()->get('bottle');
        }

        return view('steps/step3ShopComponent')->with('bottle', $bottle);
    }

}
