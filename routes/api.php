<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/schritt1', [App\Http\Controllers\BottleSizeController::class, 'showInhalt']);
Route::get('/cart/count',  [App\Http\Controllers\ShoppingCartController::class, 'getCartCount']);
Route::get('/bottleSize', [App\Http\Controllers\BottleSizeController::class, 'showBottleSizes']);

Route::get('/removeAll',  [App\Http\Controllers\ShoppingCartController::class, 'removeAll']);



Route::get('/session', function() {
    session()->put('user_id', 123);
    return response()->json(['session' => session()->all()]);
});

Route::get('/session2', function() {
    return response()->json(['session' => session()->all()]);
});