<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SiteController::class, 'renderArticleSearch']);
Route::get('article/{code}', [SiteController::class, 'renderArticleView']);
Route::get('article-create', [SiteController::class, 'renderArticleCreate']);
Route::post('article-create', [SiteController::class, 'createAndRedirect']);
Route::get('article-create-success', [SiteController::class, 'renderArticleCreateSuccess']);
