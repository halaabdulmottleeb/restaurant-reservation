<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
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

Route::post('register', [ApiAuthController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [ApiAuthController::class, 'user']);
    Route::post('staff-user', [UserController::class, 'createStaffUser']);
    Route::get('list-menu-items', [MealController::class, 'getAll']);
    Route::get('list-tables', [TableController::class, 'getAll']);
    Route::get('check-availability', [ReservationController::class, 'checkAvailability']);
    Route::post('reserve-table', [ReservationController::class, 'reserve']);
    Route::post('place-order', [OrderController::class, 'createOrder']);
    Route::post('checkout', [OrderController::class, 'checkout']);
});
