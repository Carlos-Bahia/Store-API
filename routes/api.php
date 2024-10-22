<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/products', ProductController::class);

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World!'
    ]);
});
