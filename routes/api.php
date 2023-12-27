<?php

use App\Http\Controllers\CampeonatoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout/{id}',[UserController::class,'logout'])->name('user.logout');
});

Route::post('/login',[UserController::class,'login'])->name('user.login');
Route::post('/register',[UserController::class,'store'])->name('user.store');
Route::delete('/user/{id}',[UserController::class,'destroy'])->name('user.destroy');
Route::patch('/user/{id}',[UserController::class,'update'])->name('user.update');

Route::get('/campeonato',[CampeonatoController::class,'index'])->name('campeonato.index');
Route::get('/campeonato/{id}',[CampeonatoController::class,'show'])->name('campeonato.show');
Route::post('/campeonato',[CampeonatoController::class,'store'])->name('campeonato.store');
Route::patch('/campeonato/{id}',[CampeonatoController::class,'update'])->name('campeonato.update');
Route::delete('/campeonato/{id}',[CampeonatoController::class,'destroy'])->name('campeonato.destroy');


Route::get('/categoria',[CategoriaController::class,'index'])->name('categoria.index');
Route::get('/categoria/{id}',[CategoriaController::class,'show'])->name('categoria.show');
Route::post('/categoria',[CategoriaController::class,'store'])->name('categoria.store');
Route::patch('/categoria/{id}',[CategoriaController::class,'update'])->name('categoria.update');
Route::delete('/categoria/{id}',[CategoriaController::class,'destroy'])->name('categoria.destroy');

Route::get('/torneo',[TorneoController::class,'index'])->name('torneo.index');
Route::get('/torneo/{id}',[TorneoController::class,'show'])->name('torneo.show');
Route::post('/torneo',[TorneoController::class,'store'])->name('torneo.store');
Route::patch('/torneo/{id}',[TorneoController::class,'update'])->name('torneo.update');
Route::delete('/torneo/{id}',[TorneoController::class,'destroy'])->name('torneo.destroy');

