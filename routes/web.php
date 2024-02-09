<?php

use App\Http\Controllers\CreateArticlePageController;
use App\Http\Controllers\MainPageController;
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

Route::get('/', [MainPageController::class, 'render']);
Route::get('create-article', [CreateArticlePageController::class, 'renderCreateArticle']);
Route::post('create-article', [CreateArticlePageController::class, 'createAndRedirect']);
Route::get('create-article-success', [CreateArticlePageController::class, 'renderCreateArticleSuccess']);
