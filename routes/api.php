<?php

use App\Http\Controllers\ItemController;
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



Route::middleware('auth:sanctum')->group(function (){
    Route::get('/item',[ItemController::class,'index']);
    Route::post('item/store',[ItemController::class,'store']);
    Route::patch('item/{id}',[ItemController::class,'update']);
    Route::delete('item/{id}',[ItemController::class,'destroy']);
});