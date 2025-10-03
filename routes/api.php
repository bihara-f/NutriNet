<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    DietPlanController,
    NutritionController,
    UserController
};

// Public API Routes
// Authentication endpoints accessible without authentication

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Authenticated API Routes
// Requires valid API token for access

// Protected API routes for authenticated users
/*
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // API routes implementation pending
});
*/

// Admin API Routes
// Requires admin privileges and authentication

// MongoDB Analytics API Routes
// Advanced nutrition analytics using MongoDB

// MongoDB nutrition analytics routes
/*
Route::prefix('mongodb/nutrition')->group(function () {
    // MongoDB routes implementation pending
});
*/

// Admin-only API Routes
// Restricted to administrative users

// Admin API routes for system management
/*
Route::middleware(['auth:sanctum', 'throttle:api', 'admin'])->prefix('admin')->group(function () {
    // Admin API routes implementation pending
});
*/
