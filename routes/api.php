<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\HomeController;
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
Route::post('/block-user/{id}', [UserController::class, 'blockUser']);
Route::post('/deblock-user/{id}', [UserController::class, 'unBlockUser']);
Route::get('/all-user', [UserController::class, 'getUser']);
Route::post('/search-user/{page}', [UserController::class, 'search']);
Route::get('/user-per-page/{page}', [UserController::class, 'getUserPerPage']);



Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);


Route::post('/add-bookmark', [BookmarkController::class, 'addBookmark']);
Route::get('/get-bookmark', [BookmarkController::class, 'getBookmark']);
Route::post('/delete-bookmark/{id}', [BookmarkController::class, 'deleteBookmark']);

Route::get('/all-hotel', [HotelController::class, 'getHotel']);
Route::get('/home-hotel-per-page/{page}', [HotelController::class, 'getHomeHotelPerPage']);
Route::get('/hotel-per-page/{page}', [HotelController::class, 'getHotelPerPage']);
Route::post('/search-hotel/{page}', [HotelController::class, 'search']);
Route::post('/add-hotel', [HotelController::class, 'addHotel']);
Route::post('/update-hotel/{id}', [HotelController::class, 'updateHotel']);
Route::delete('/delete-hotel/{id}', [ HotelController::class, 'deleteHotel']);
Route::get('/details-hotel/{id}', [ HotelController::class, 'detailsHotel']);

Route::get('/all-agency', [AgencyController::class, 'getAgency']);
Route::get('/home-agency-per-page/{page}', [AgencyController::class, 'getHomeAgencyPerPage']);
Route::get('/agency-per-page/{page}', [AgencyController::class, 'getAgencyPerPage']);
Route::post('/search-agency/{page}', [AgencyController::class, 'search']);
Route::post('/add-agency', [AgencyController::class, 'addAgency']);
Route::post('/update-agency/{id}', [AgencyController::class, 'updateAgency']);
Route::delete('/delete-agency/{id}', [ AgencyController::class, 'deleteAgency']);
Route::get('/details-agency/{id}', [ AgencyController::class, 'detailsAgency']);

Route::get('/all-employe', [EmployeController::class, 'getEmploye']);
Route::get('/employe-per-page/{page}', [EmployeController::class, 'getEmployePerPage']);
Route::post('/search-employe/{page}', [EmployeController::class, 'search']);
Route::post('/add-employe', [EmployeController::class, 'addEmploye']);
Route::post('/update-employe/{id}', [EmployeController::class, 'updateEmploye']);
Route::get('/details-employe/{id}', [ EmployeController::class, 'detailsEmploye']);

Route::get('/home', [HomeController::class, 'home']);
Route::get('/stats', [HomeController::class, 'stats']);

