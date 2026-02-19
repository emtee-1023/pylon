<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;


// Routes for the Pylon API to Fetch Configurations
Route::post('/config', [ConfigController::class, 'getConfig'])->middleware(middleware: 'apikey');

//Authentication routes for using the Admin UI and generating API keys
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/profile', [AuthenticationController::class, 'profile'])->middleware('auth:sanctum');
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
