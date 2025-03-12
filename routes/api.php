<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', App\Http\Controllers\Api\UserController::class);
    Route::apiResource('transactions', App\Http\Controllers\FundTransactionController::class, ['except'=> ['store', 'update', 'destroy']]);
    Route::get('user/transactions', [App\Http\Controllers\FundTransactionController::class, 'getAuthedUserTransactions']);
    Route::get('users/{id}/transactions', [App\Http\Controllers\FundTransactionController::class, 'getTransactionsByUser']);
    Route::post('users/{id}/transactions', [App\Http\Controllers\FundTransactionController::class, 'store']);
});
