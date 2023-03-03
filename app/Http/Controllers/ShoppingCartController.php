<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\BottleSize;
use App\Models\Ingrediente;


class ShoppingCartController extends Controller
{
    public function storeCart(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::find($ingredienteID);
        $bottle = $this->getBottle($request);
        if ((Cart::count() + $request->amount) <= $bottle->amount) {
            Cart::add(
                array(
                    'id' => $ingrediente->id,
                    'name' => $ingrediente->name,
                    'qty' => $request->amount,
                    'price' => $ingrediente->price,
                    'options' => array('image' => $ingrediente->image, 'piece' => $ingrediente->piece),
                )
            );
            return response()->json(['stored' => true, 'image' => $ingrediente->image, 'piece' => $ingrediente->piece, 'count' => Cart::count(), 'reqCount' => $request->amount, 'amount' => $bottle->amount]);
        }
        return response()->json(['stored' => false]);
    }

    public function deleteCart(Request $request, $ingredienteID)
    {
        $bottle = $this->getBottle($request);
        $piece = Cart::get($ingredienteID)->options->piece;
        $count = Cart::count() - Cart::get($ingredienteID)->qty;
        Cart::remove($ingredienteID);
        return response()->json(['piece' => $piece, 'count' => $count, 'amount' => $bottle->amount]);
    }

    public function removeAllFromCard(Request $request)
    {
        Cart::destroy();
    }


    public function increaseCardQty(Request $request, $ingredienteID)
    {
        $bottle = $this->getBottle($request);
        if (Cart::count() < $bottle->amount) {
            $id = Cart::get($ingredienteID)->id;
            $newqty = Cart::get($ingredienteID)->qty + 1;
            Cart::update($ingredienteID, $newqty); // Will update the quantity
            return response()->json(['stored' => true, 'piece' => Cart::get($ingredienteID)->options->piece, 'count' => Cart::count(), 'newqty' => $newqty, 'amount' => $bottle->amount, 'id' => $id]);
        }
        return response()->json(['stored' => false]);
    }

    public function decreaseCardQty(Request $request, $ingredienteID)
    {
        $bottle = $this->getBottle($request);
        $piece = Cart::get($ingredienteID)->options->piece;
        $id = Cart::get($ingredienteID)->id;
        $count = Cart::count() - 1;
        $newqty = Cart::get($ingredienteID)->qty - 1;
        Cart::update($ingredienteID, $newqty); // Will update the quantity
        return response()->json(['piece' => $piece, 'count' => $count, 'newqty' => $newqty, 'amount' => $bottle->amount, 'id' => $id]);
    }

    public function showCard(Request $request)
    {
        $bottle = $this->getBottle($request);
        return view('steps/step3ShopComponent')->with('bottle', $bottle);
    }

    public function getCartCount(Request $request)
    {
        $cartcount = Cart::count();
        $bottle = $this->getBottle($request);
        return response()->json(['cartCount' => $cartcount, 'bottle' => $bottle]);
    }

    public function getCartContent(Request $request)
    {
        $cart = Cart::content();
        $cartTotal = Cart::total();
        $cartSubTotal = Cart::subtotal();
        return response()->json(['cart' => $cart, 'cartTotal' => $cartTotal, 'cartSubTotal' => $cartSubTotal]);
    }

    public function getBottle(Request $request)
    {
        if ($request->session()->get('bottle') == true) {
            return $request->session()->get('bottle');
        } else {
            return BottleSize::findOrFail("4");
        }
    }

    public function removeAll(Request $request)
    {
        Cart::destroy();
        return response()->json(['test' => "test"]);
    }
}