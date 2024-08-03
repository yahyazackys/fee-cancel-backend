<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiFeeCancelController;
use App\Http\Controllers\Api\ApiAuthController;

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

Route::prefix('fee-cancel')->group(function () {
    Route::post('store', [ApiFeeCancelController::class, 'store'])->name('store');
    Route::get('index', [ApiFeeCancelController::class, 'index'])->name('index');
    Route::get('show/{id}', [ApiFeeCancelController::class, 'show'])->name('show');
    Route::post('update/{id}', [ApiFeeCancelController::class, 'update'])->name('update');
    Route::get('destroy/{id}', [ApiFeeCancelController::class, 'destroy'])->name('destroy');
});

Route::prefix('users')->group(function () {
    Route::post('login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('register', [ApiAuthController::class, 'register'])->name('register');
    Route::post('logout', [ApiAuthController::class, 'logout'])->name('logout');
});
