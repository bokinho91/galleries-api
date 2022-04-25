<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use GuzzleHttp\Middleware;
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
Route::get('/galleries',[GalleryController::class, 'index']);


//Private routes
Route::middleware('auth')->group(function () {
    //My profile
    Route::get('/myprofile',[AuthController::class, 'me']);

    //Gallery
    Route::get('/my_galleries', [GalleryController::class, 'myGalleries']);
    Route::get('/authors', [GalleryController::class, 'authorsGalleries']);
    Route::post('/galleries',[GalleryController::class, 'store']);
    Route::get('/galleries/{gallery}',[GalleryController::class, 'show']);
    Route::put('/galleries',[GalleryController::class, 'update']);
    Route::delete('/galleries/{gallery}',[GalleryController::class, 'destroy']);
    
    
    //Comments
    Route::get('/comments',[CommentController::class, 'index']);
    Route::post('/comments',[CommentController::class, 'store']);
    Route::get('/comments/{gallery}',[CommentController::class, 'show']);
    Route::delete('/comments/{comment}',[CommentController::class, 'destroy']);
});