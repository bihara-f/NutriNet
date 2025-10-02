<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    DietPlanController,
    NutritionController,
    UserController
};

/*
|--------------------------------------------------------------------------
| API Routes - Public
|--------------------------------------------------------------------------
*/

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

/*
|--------------------------------------------------------------------------
| API Routes - Authenticated (Temporarily commented out for admin testing)
|--------------------------------------------------------------------------
*/

// Commenting out API routes temporarily to focus on admin functionality
/*
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // API routes will be implemented later
});
*/

/*
|--------------------------------------------------------------------------
| API Routes - Admin Only
|--------------------------------------------------------------------------
*/

    /*
    |--------------------------------------------------------------------------
    | MongoDB Advanced Analytics API Routes (Temporarily commented out)
    |--------------------------------------------------------------------------
    */

    // Commenting out MongoDB routes temporarily
    /*
    Route::prefix('mongodb/nutrition')->group(function () {
        // MongoDB routes will be implemented later
    });
    */

/*
|--------------------------------------------------------------------------
| API Routes - Admin Only (Temporarily commented out)
|--------------------------------------------------------------------------
*/

// Commenting out admin API routes temporarily
/*
Route::middleware(['auth:sanctum', 'throttle:api', 'admin'])->prefix('admin')->group(function () {
    // Admin API routes will be implemented later
});
*/
