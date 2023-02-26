<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Bottle-Size-Routes
Route::get('/custom/bottleSize', [App\Http\Controllers\BottleSizeController::class, 'showBottleSizes'])->name('showBottleSizes');
Route::get('/schritt1/{bottle}', [App\Http\Controllers\BottleSizeController::class, 'showInhalt'])->name('showInhalt');

//Ingrediente-Routes
Route::get('/custom/fruits', [App\Http\Controllers\IngredienteController::class, 'showFruits'])->name('showFruits');
Route::get('/custom/veggie', [App\Http\Controllers\IngredienteController::class, 'showVeggie'])->name('showVeggie');
Route::get('/custom/liquids', [App\Http\Controllers\IngredienteController::class, 'showLiquids'])->name('showLiquids');
Route::get('/create', [App\Http\Controllers\IngredienteController::class, 'create'])->name('create');
Route::post('/delete/ingrediente/{zutat}', [App\Http\Controllers\IngredienteController::class, 'deleteIngediengte'])->name('deleteZutat');
Route::post('/updated/ingrediente/{zutat}', [App\Http\Controllers\IngredienteController::class, 'updateIngrediente']);
Route::post('/update/ingrediente/{zutat}', [App\Http\Controllers\IngredienteController::class, 'showUpdateField'])->name('update');

//ShoppingCard-Routes
Route::post('/addCart/{ingredienteID}', [App\Http\Controllers\ShoppingCartController::class, 'storeCart'])->name('storeInCart');
Route::post('/deleteCart/{carditem}', [App\Http\Controllers\ShoppingCartController::class, 'deleteCart'])->name('deleteCart');
Route::get('/removeAll', [App\Http\Controllers\ShoppingCartController::class, 'removeAllFromCard'])->name('removeAll');
Route::post('/increaseCardQty/{carditem}', [App\Http\Controllers\ShoppingCartController::class, 'increaseCardQty'])->name('increaseCardQty');
Route::post('/decreaseCardQty/{carditem}', [App\Http\Controllers\ShoppingCartController::class, 'decreaseCardQty'])->name('decreaseCardQty');
Route::get('/showCard', [App\Http\Controllers\ShoppingCartController::class, 'showCard'])->name('showCard');



//Route::get('/cart/count',  [App\Http\Controllers\ShoppingCartController::class, 'getCartCount']);
Route::get('/cart/count',  [App\Http\Controllers\ShoppingCartController::class, 'getCartCount']);
Route::get('/fruits', [App\Http\Controllers\IngredienteController::class, 'getFruits']);
Route::get('/vegetables', [App\Http\Controllers\IngredienteController::class, 'getVegetables']);
Route::get('/liquid', [App\Http\Controllers\IngredienteController::class, 'getLiquid']);
Route::get('/cartContent', [App\Http\Controllers\ShoppingCartController::class, 'getCartContent']);
Route::get('/removeAll', [App\Http\Controllers\ShoppingCartController::class, 'removeAll']);
//Route::get('/bottleSize', [App\Http\Controllers\BottleSizeController::class, 'showBottleSizes']);


Route::post('/create/ingrediente', [App\Http\Controllers\IngredienteController::class, 'store']);
Route::post('/addCart/{zutat}', [App\Http\Controllers\ShoppingCartController::class, 'storeCart']);

// needed to refer to the vue router
Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');