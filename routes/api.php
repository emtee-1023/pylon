<?php

use App\Http\Controllers\ConfigController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('apikey')->group(function () {
    Route::post('/config', [ConfigController::class, 'getConfig']);
});
