<?php

use App\Http\Controllers\MealsControllers;
use App\Http\Controllers\UsersController;
use App\Models\Meal;
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

Route::post('auth/register', [UsersController::class, 'store']);
Route::post('auth/login', [UsersController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group( function() {
    Route::post('v1/meals', [MealsControllers::class, 'store'])->can('create', Meal::class);
});
