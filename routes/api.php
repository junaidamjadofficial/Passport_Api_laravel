<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthenicationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthenicationController::class,'register']);
Route::post('login',[AuthenicationController::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::post('logout',[AuthenicationController::class,'logout']);
    Route::resource('products', ProductController::class);
});