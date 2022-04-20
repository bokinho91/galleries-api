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
Route::get('/gallery',[GalleryController::class, 'index']);


//Private routes
Route::middleware('auth')->group(function () {
    //My profile
    Route::get('/myprofile',[AuthController::class, 'me']);

    //Gallery
    Route::get('/mygallery', [GalleryController::class, 'myGalleries']);
    Route::post('/gallery',[GalleryController::class, 'store']);
    Route::get('/gallery/{gallery}',[GalleryController::class, 'show']);
    Route::put('/gallery',[GalleryController::class, 'update']);
    Route::delete('/gallery/{gallery}',[GalleryController::class, 'destroy']);

    //Comments
    Route::get('/comment',[CommentController::class, 'index']);
    Route::post('/comment',[CommentController::class, 'store']);
    Route::get('/comment/{gallery}',[CommentController::class, 'show']);
    Route::put('/comment',[CommentController::class, 'update']);
    Route::delete('/comment/{comment}',[CommentController::class, 'destroy']);
});