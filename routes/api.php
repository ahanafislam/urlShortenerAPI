<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Urls
Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

// Main url
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/urls', [UrlController::class, 'index']);
    Route::post('/shorten', [UrlController::class, 'store']);
});
