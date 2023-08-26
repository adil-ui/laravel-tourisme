<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
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
Route::post('/register', [UserController::class, 'register']);
Route::post('/update-user/{id}', [UserController::class, 'updateUser']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);

Route::post('/add-bookmark', [BookmarkController::class, 'addBookmark']);
Route::get('/all-bookmark', [BookmarkController::class, 'getBookmark']);
Route::post('/delete-bookmark/{id}', [BookmarkController::class, 'deleteBookmark']);

