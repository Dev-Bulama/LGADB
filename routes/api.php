<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WorkerController;
use App\Http\Controllers\Api\VerificationController;
use Illuminate\Support\Facades\Route;

// Public API endpoints
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
    
    // Public verification
    Route::get('/verify/{code}', [VerificationController::class, 'verify']);
    Route::get('/verify/qr/{hash}', [VerificationController::class, 'qrVerify']);
    Route::post('/verify/search', [VerificationController::class, 'search']);
    
    // Authenticated endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/password', [AuthController::class, 'changePassword']);
        
        // Worker profile
        Route::get('/worker/profile', [WorkerController::class, 'profile']);
        Route::put('/worker/profile', [WorkerController::class, 'updateProfile']);
        Route::get('/worker/documents', [WorkerController::class, 'documents']);
        Route::get('/worker/history', [WorkerController::class, 'history']);
        Route::get('/worker/notifications', [WorkerController::class, 'notifications']);
        Route::get('/worker/id-card', [WorkerController::class, 'idCard']);
    });
});
