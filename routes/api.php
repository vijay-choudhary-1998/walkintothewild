<?php

use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Admin\ParkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('login', [AdminAuthController::class, "login"]);

Route::middleware('auth:sanctum')->group(function () {
  Route::prefix('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/profile', [AdminAuthController::class, 'profile']);

    Route::get('/park-list', [ParkController::class, 'index']);
    Route::post('/park-create', [ParkController::class, 'create']);
    Route::post('/park-edit', [ParkController::class, 'update']);
    Route::delete('/park-delete/{id}', [ParkController::class, 'destroy']);
    
  });
});
