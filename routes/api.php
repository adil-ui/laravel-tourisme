<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HotelController;
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
Route::get('/get-bookmark', [BookmarkController::class, 'getBookmark']);
Route::post('/delete-bookmark/{id}', [BookmarkController::class, 'deleteBookmark']);

Route::get('/all-hotel', [HotelController::class, 'getHotel']);
Route::get('/home-hotel-per-page/{page}', [HotelController::class, 'getHomeHotelPerPage']);
Route::get('/hotel-per-page/{page}', [HotelController::class, 'getHotelPerPage']);
Route::post('/search/{page}', [HotelController::class, 'search']);
Route::post('/add-hotel', [HotelController::class, 'addHotel']);
Route::post('/update-hotel/{id}', [HotelController::class, 'updateHotel']);
Route::delete('/delete-hotel/{id}', [ HotelController::class, 'deleteHotel']);
Route::get('/details-hotel/{id}', [ HotelController::class, 'detailsHotel']);
