<?php

use App\Http\Controllers\Api\ApiDeliveryController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccessTokensController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user('sanctum');
});

//Route::get('/products',[ProductsController::class,'index']);

Route::apiResource('products',ProductsController::class, array("as" => "api"))
    ->except('create','edit');


Route::post('/auth/access-tokens',[AccessTokensController::class,'store'])
    ->middleware('guest:sanctum');

Route::delete('/auth/access-tokens/{token?}',[AccessTokensController::class,'destroy'])
    ->middleware('auth:sanctum');

// order delivery
Route::get('/order-delivery/{id}',[ApiDeliveryController::class, 'show']);
Route::put('/order-delivery/{delivery}',[ApiDeliveryController::class, 'update']);


//API_TOKEN="IPR6QrstEsWnMMC8JtHajiqnVKMh7vr3SlekHCbCyAM"
//CURRENCY_CONVERTER_API_KEY="403818d724ce827ecc4a"
