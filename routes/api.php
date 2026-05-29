<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Helpers\Enum\RoleEnum;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Superadmin only
    Route::middleware('role:' . RoleEnum::SUPERADMIN->value)->group(function () {
        // nanti diisi
    });

    // Superadmin & Admin
    Route::middleware('role:' . RoleEnum::SUPERADMIN->value . ',' . RoleEnum::ADMIN->value)->group(function () {
        // nanti diisi
    });

    // Teacher only
    Route::middleware('role:' . RoleEnum::TEACHER->value)->group(function () {
        // nanti diisi
    });

    // Student only
    Route::middleware('role:' . RoleEnum::STUDENT->value)->group(function () {
        Route::prefix('attendance')->group(function () {
            Route::get('/', [AttendanceController::class, 'index']);
            Route::post('/check-in', [AttendanceController::class, 'checkIn']);
            Route::post('/check-out', [AttendanceController::class, 'checkOut']);
        });
    });

});
