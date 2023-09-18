<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApi\AuthController;

Route::prefix('admin/api')->group(function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::middleware(['admin'])->group(function() {
        Route::apiResource('task', TaskController::class);
        Route::apiResource('archive', ArchiveController::class);
    });
});
