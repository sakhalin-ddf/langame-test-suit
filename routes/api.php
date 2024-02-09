<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UploadController::class)->prefix('/upload')->group(static function () {
    Route::post('/', 'save');
});

Route::controller(ArticleController::class)->prefix('/articles')->group(static function () {
    Route::post('/', 'save');
    Route::post('search', 'search');
});
