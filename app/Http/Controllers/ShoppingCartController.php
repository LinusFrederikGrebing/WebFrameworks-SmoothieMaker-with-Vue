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
        $ingrediente = Ingrediente::findOrFail($ingredienteID); 
        $bottle = $this->getBottle($request);
        $liquidItems = Cart::content()->filter(function($item) {
            return $item->options->type == 'liquid';
        });
        $amount = ($liquidItems->isNotEmpty()) ? $bottle->amount + 1 : $bottle->amount;
        if ((Cart::count() + $request->amount) <= $amount) {
            Cart::add([
                'id' => $ingrediente->id,
                'name' => $ingrediente->name,
                'qty' => $request->amount,
                'price' => $ingrediente->price,
                'options' => [
                    'image' => $ingrediente->image,
                    'piece' => $ingrediente->piece,
                    'type' =>  $ingrediente->type,
                ],
            ]);
            return response()->json([
                'stored' => true,
                'image' => $ingrediente->image,
                'piece' => $ingrediente->piece,
                'count' => Cart::count(),
                'reqCount' => $request->amount,
                'amount' => $bottle->amount,
            ]);
        }
        return response()->json(['stored' => false]);
    }
    
    public function storeLiquidToCart(Request $request, $ingredienteID)
    {
        $ingrediente = Ingrediente::findOrFail($ingredienteID);
        $liquidItems = Cart::content()->filter(function($item) {
            return $item->options->type == 'liquid';
        });
        foreach ($liquidItems as $item) { 
            Cart::remove($item->rowId);
        }
        Cart::add([
            'id' => $ingrediente->id,
            'name' => $ingrediente->name,
            'qty' => $request->amount,
            'price' => $ingrediente->price,
            'options' => [
                'image' => $ingrediente->image,
                'piece' => $ingrediente->piece,
                'type' =>  $ingrediente->type,
            ],
        ]);
        return response()->json(['stored' => true]);
    }

    /**
     * Delete item from the cart
     */
    public function deleteCart(Request $request, $ingredienteID)
    {
        // Get the bottle and item details
        $bottle = $this->getBottle($request);
        $item = Cart::get($ingredienteID);
        // Remove the item from the cart
        Cart::remove($ingredienteID);

        // Return response with updated details
        $piece = $item->options->piece;
        $count = Cart::count();
        $amount = $bottle->amount;
        return response()->json(['piece' => $piece, 'count' => $count, 'amount' => $bottle->amount]);
    }

    /**
     * Remove all items from the cart
     */
    public function removeAllFromCart(Request $request)
    {
        Cart::destroy();
    }

    /**
     * Increase item quantity in the cart
     */
    public function increaseCartQty(Request $request, $ingredienteID)
    {
        // Get the bottle and item details
        $bottle = $this->getBottle($request);
        $item = Cart::get($ingredienteID);

        // Check if cart is full
        if (Cart::count() >= $bottle->amount) {
            return response()->json(['stored' => false]);
        }
        // Update item quantity and return response with updated details
        $newqty = $item->qty + 1;
        Cart::update($ingredienteID, $newqty);
        $stored = true;
        $piece = $item->options->piece;
        $count = Cart::count();
        $id = $item->id;
        return response()->json(['stored' => true, 'piece' => Cart::get($ingredienteID)->options->piece, 'count' => Cart::count(), 'newqty' => $newqty, 'amount' => $bottle->amount, 'id' => $id]);
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
        return $request->session()->get('bottle') ?: BottleSize::findOrFail("4");
    }

    public function getLiquid(Request $request)
    {
        $liquidItems = collect(Cart::content())->filter(function($item) {
            return $item->options->type == 'liquid';
        });
        return response()->json(compact('liquidItems'));
    }

    public function removeAll(Request $request)
    {
        Cart::destroy();
        return response()->json(['test' => "test"]);
    }
}