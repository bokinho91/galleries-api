<?php

use App\Http\Controllers\AuthController;
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

//Public route
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');


//Private routes
Route::middleware('auth')->group(function () {
    
});