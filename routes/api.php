<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeploymentController;


// Routes for the Pylon API to Fetch Configurations
Route::post('/config', [ConfigController::class, 'getConfig'])->middleware(middleware: 'apikey');

//Authentication routes for using the Admin UI and generating API keys
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/profile', [AuthenticationController::class, 'profile'])->middleware('auth:sanctum');
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

//Admin UI routes for managing deployments and companies
Route::get('/deployments', [DeploymentController::class, 'getDeployedApps'])->middleware('auth:sanctum');
Route::get('/api-keys', [DeploymentController::class, 'getApiKeys'])->middleware('auth:sanctum');
Route::get('/companies', [DeploymentController::class, 'getCompanies'])->middleware('auth:sanctum');
Route::delete('/api-keys/{id}', [DeploymentController::class, 'deleteApiKey'])->middleware('auth:sanctum');
Route::post('/companies', [DeploymentController::class, 'createCompany'])->middleware('auth:sanctum');
Route::post('/generate-api-key', [DeploymentController::class, 'generateApiKey'])->middleware('auth:sanctum');
Route::post('/app-configs', [DeploymentController::class, 'createAppConfig'])->middleware('auth:sanctum');
Route::get('/app-configs', [DeploymentController::class, 'getAppConfigs'])->middleware('auth:sanctum');
Route::get('/app-configs/{companyId}/{appId}', [DeploymentController::class, 'getAppConfig'])->middleware('auth:sanctum');
Route::patch('/app-configs/update', [DeploymentController::class, 'patchAppConfig'])->middleware('auth:sanctum');
Route::delete('/app-configs/delete', [DeploymentController::class, 'deleteAppConfig'])->middleware('auth:sanctum');
