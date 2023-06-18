<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\UserController;
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

/**
 * User Registration
 *
 * Aftre you finished the user registration process, you'll get a 200 OK response.
 *
 * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
 *
 * @response 400 
 * @responseField status The status of this API (`up` or `down`).
 * @responseField services Map of each downstream service and their status (`up` or `down`).
 */
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/movie', [MovieController::class, 'index'])->name('movie.index');
Route::get('/movie/{movie}', [MovieController::class, 'show'])->name('movie.show');
Route::post('/comment', [CommentController::class, 'store']);
Route::middleware('auth:api')->group( function () {
    // Route::apiResource('movie', MovieController::class);
    Route::post('/movie', [MovieController::class, 'store'])->name('movie.store');
    Route::put('/movie/{movie}', [MovieController::class, 'update'])->name('movie.update');
    Route::delete('/movie/{movie}', [MovieController::class, 'destroy'])->name('movie.delete');
});