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
                    'type' =>  $ingrediente->type,
                ],
            ]);
            return response()->json([
                'stored' => true,
                'image' => $ingrediente->image,
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
       
        if($item->options->type == 'liquid'){
            $wasLiquid = true;
        } else {
            $wasLiquid = false;
        }
         Cart::remove($ingredienteID);
        // Return response with updated details
        $image = $item->options->image;
        $count = Cart::count();
        $amount = $bottle->amount; 
      
        return response()->json(['image' => $image, 'count' => $count, 'amount' => $amount, 'wasLiquid' => $wasLiquid]);
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
    public function increaseCardQty(Request $request, $ingredienteID)
    {   
        $bottle = $this->getBottle($request);
        $liquidItems = Cart::content()->filter(function($item) {
            return $item->options->type == 'liquid';
        });
        $amount = ($liquidItems->isNotEmpty()) ? $bottle->amount + 1 : $bottle->amount;
   
        if (Cart::count() < $amount) {
            $id = Cart::get($ingredienteID)->id;
            $newqty = Cart::get($ingredienteID)->qty + 1;
            Cart::update($ingredienteID, $newqty); // Will update the quantity
            return response()->json(['stored' => true, 'image' => Cart::get($ingredienteID)->options->image, 'count' => Cart::count(), 'newqty' => $newqty, 'amount' => $amount, 'id' => $id]);
        }
        return response()->json(['stored' => false]);
    }
    public function decreaseCardQty(Request $request, $ingredienteID)
    {
        $bottle = $this->getBottle($request);
        $image = Cart::get($ingredienteID)->options->image;
        $id = Cart::get($ingredienteID)->id;
        $count = Cart::count() - 1;
        $newqty = Cart::get($ingredienteID)->qty - 1;
        Cart::update($ingredienteID, $newqty); // Will update the quantity
        return response()->json(['image' => $image, 'count' => $count, 'newqty' => $newqty, 'amount' => $bottle->amount, 'id' => $id]);
    }
    public function getCartCount(Request $request)
    {
        $bottle = $this->getBottle($request);
        $liquidItems = Cart::content()->filter(function($item) {
            return $item->options->type == 'liquid';
        });
        $cartcount = ($liquidItems->isNotEmpty()) ?  Cart::count() - 1 : Cart::count();
        $liquidCount = ($liquidItems->isNotEmpty()) ?  1 : 0;
        return response()->json(['cartCount' => $cartcount, 'bottle' => $bottle, 'liquidCount' => $liquidCount]);
    }
    public function getCartContent(Request $request)
    {
        $cart = Cart::content();
        $cartTotal = Cart::total();
        $cartSubTotal = Cart::subtotal();
        $bottle = $this->getBottle($request);
        return response()->json(['cart' => $cart, 'cartTotal' => $cartTotal, 'cartSubTotal' => $cartSubTotal, 'bottle' => $bottle]);
    }

    public function getBottle(Request $request)
    {
        if ($request->session()->get('bottle') == true) {
            return $request->session()->get('bottle');
        } else {
            return BottleSize::findOrFail("4");
        }

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
        return [];
    }
}