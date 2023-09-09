<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* Registracija */

Route::post('/registracija',[UserController::class,'registracija']);

/* Prijava */


Route::post('/prijava',[UserController::class,'prijava']);

/* Odjava i provjera  */

Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);

/* Kategorija */

Route::post('/addCategory',[CategoryController::class,'addCategory']);
Route::get('/getCategories',[CategoryController::class,'getCategories']);

/* Lekcija */

Route::post('/dodajLekciju',[LessonController::class,'dodajLekciju']);
Route::get('/getLesson',[LessonController::class,'getLesson']);
Route::post('/deleteLesson/{id}',[LessonController::class,'deleteLesson']);
Route::post('/urediLekciju/{id}',[LessonController::class,'urediLekciju']);
Route::get('/singleLesson/{id}',[LessonController::class,'getLekcija']);
Route::get('/dohvatiLekciju/{id}',[LessonController::class,'dohvatiLekciju']);
/* Details */

Route::post('/addDetails',[DetailController::class,'addDetails']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
