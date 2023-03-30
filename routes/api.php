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

//Ingredient-Routes
Route::get('/create', [App\Http\Controllers\IngredientController::class, 'create'])->name('create');
Route::post('/delete/ingredient/{ingredient}', [App\Http\Controllers\IngredientController::class, 'deleteIngediengte'])->name('deleteZutat');
Route::get('/getIngredientsList', [App\Http\Controllers\IngredientController::class, 'getIngredientsList']);
Route::get('/liquid', [App\Http\Controllers\IngredientController::class, 'getLiquidList']);
Route::post('/updated/ingredient/{ingredient}', [App\Http\Controllers\IngredientController::class, 'updateIngredient']);
Route::post('/update/ingredient/{ingredient}', [App\Http\Controllers\IngredientController::class, 'showUpdateField'])->name('update');
Route::post('/create/ingredient', [App\Http\Controllers\IngredientController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

