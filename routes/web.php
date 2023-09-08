<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* Registracija */

Route::post('/registracija',[UserController::class,'registracija']);

/* Prijava */


Route::post('/prijava',[UserController::class,'prijava']);

/* Odjava i provjera  */

Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
