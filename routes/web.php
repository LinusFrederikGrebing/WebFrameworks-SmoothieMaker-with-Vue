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
Auth::routes();

//Bottle-Size-Routes
Route::get('/schritt1/{bottle}', [App\Http\Controllers\BottleSizeController::class, 'storeBottleSize'])->name('storeBottleSize');
Route::get('/bottleSize', [App\Http\Controllers\BottleSizeController::class, 'showBottleSizes']);

//ShoppingCard-Routes
Route::post('/deleteCart/{carditem}', [App\Http\Controllers\ShoppingCartController::class, 'deleteCart'])->name('deleteCart');
Route::post('/increaseCardQty/{carditem}', [App\Http\Controllers\ShoppingCartController::class, 'increaseCardQty'])->name('increaseCardQty');
Route::post('/decreaseCardQty/{carditem}', [App\Http\Controllers\ShoppingCartController::class, 'decreaseCardQty'])->name('decreaseCardQty');
Route::get('/cart/count', [App\Http\Controllers\ShoppingCartController::class, 'getCurrentCartCount']);
Route::get('/cartContent', [App\Http\Controllers\ShoppingCartController::class, 'getCurrentCartContent']);
Route::get('/cartTotal', [App\Http\Controllers\ShoppingCartController::class, 'getCurrentCartTotal']);
Route::post('/addCart/{ingrediente}', [App\Http\Controllers\ShoppingCartController::class, 'storeIngredienteToCart']);
Route::get('/removeAll', [App\Http\Controllers\ShoppingCartController::class, 'removeAllFromCartList']);
Route::get('/getCurrentLiquid', [App\Http\Controllers\ShoppingCartController::class, 'getCurrentLiquid']);
Route::get('/getCurrentBottle', [App\Http\Controllers\ShoppingCartController::class, 'getCurrentBottle']);

//Preset-Routes
Route::get('/checkPreset/{presetName}', [App\Http\Controllers\PresetController::class, 'checkPreset'])->name('checkPreset');
Route::post('/storeAsPreset', [App\Http\Controllers\PresetController::class, 'storeAsPreset'])->name('storeAsPreset');
Route::get('/storeExistingPreset/{presetName}', [App\Http\Controllers\PresetController::class, 'storeExistingPreset'])->name('storeExistingPreset');
Route::get('/user-presets', [App\Http\Controllers\PresetController::class, 'getUserPresets']);
Route::get('/deletePreset/{ingrediente}', [App\Http\Controllers\PresetController::class, 'deleteUserPreset'])->name('deletePreset');

Route::get('/checkLoggedInUser', [App\Http\Controllers\GateController::class, 'checkLoggedInUser'])->name('checkLoggedInUser');
Route::get('/getUserRole', [App\Http\Controllers\GateController::class, 'getUserRole'])->name('getUserRole');


Route::get('/getIngredientInfo/{ingredientId}', [App\Http\Controllers\IngredientInfoController::class, 'getIngredientInfo'])->name('getIngredientInfo');

Route::post('/updated/ingredienteInfo/{ingrediente}', [App\Http\Controllers\IngredientInfoController::class, 'updateIngrediente']);
Route::post('/update/ingredienteInfo/{ingrediente}', [App\Http\Controllers\IngredientInfoController::class, 'showUpdateField'])->name('update');
Route::post('/create/ingredienteInfo', [App\Http\Controllers\IngredientInfoController::class, 'store']);

// needed to refer to the vue router
Route::get('{any}', function () {
    return view('index');
})->where('any','.*');
