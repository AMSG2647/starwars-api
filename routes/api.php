<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StarshipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;
use Illuminate\Support\Facades\Route;

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

/* Routes Auth*/
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwtUser')->group(function (){
    /* Routes Users*/
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/starships', StarshipController::class);
});


Route::apiResource('/vehicles', VehiclesController::class);




//Route::group(['prefix' =>'users'],function () {
//    //Route::get('/login', [UserController::class, 'login']);
//});



