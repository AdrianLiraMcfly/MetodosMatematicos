<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetodosNumericosController;

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



Route::get('/', [MetodosNumericosController::class, 'index']);
Route::post('/euler-mejorado', [MetodosNumericosController::class, 'eulerMejorado']);
Route::post('/runge-kutta', [MetodosNumericosController::class, 'rungeKutta']);
Route::post('/newton-raphson', [MetodosNumericosController::class, 'newtonRaphson']);
