<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');

//Login
Route::GET('/account/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
Route::POST('/account/logout', [App\Http\Controllers\CustomAuth::class, 'customlogout'])->name('logout');
Route::POST('/account/set_password', [App\Http\Controllers\CustomAuth::class, 'set_password'])->name('set.password');
Route::POST('/account/login/cek_login', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');

//GET ADMIN

Route::prefix('account')->name('account.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/article', [App\Http\Controllers\AdminArticleController::class, 'index'])->name('article');
    Route::get('/article/new', [App\Http\Controllers\AdminArticleController::class, 'new'])->name('article.new');
    Route::get('/article/{post}/edit', [App\Http\Controllers\AdminArticleController::class, 'new'])->name('article.edit');
    Route::get('/article/update/{post}', [App\Http\Controllers\AdminArticleController::class, 'update'])->name('article.update');
    Route::get('/article/store', [App\Http\Controllers\AdminArticleController::class, 'store'])->name('article.store');
    Route::get('/article/json', [App\Http\Controllers\AdminArticleController::class, 'json']);
});
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/store/quick', [App\Http\Controllers\AdminArticleController::class, 'storeJson'])->name('storeJson');
    Route::get('/json', [App\Http\Controllers\AdminArticleController::class, 'json']);
});
