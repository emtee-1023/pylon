<?php

use Illuminate\Support\Facades\Route;

use function Pest\version;

Route::get('/', function () {
    return response()->json([
        'framework_version' => app()->version(),
        'api_version' => '1.0.0'
    ]);
});
