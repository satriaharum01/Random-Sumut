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
    Route::GET('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::GET('/article', [App\Http\Controllers\AdminArticleController::class, 'index'])->name('article');
    Route::GET('/category', [App\Http\Controllers\AdminCategoryController::class, 'index'])->name('category');
    Route::GET('/tag', [App\Http\Controllers\AdminTagsController::class, 'index'])->name('tag');

    Route::prefix('article')->name('article.')->group(function () {
        Route::GET('/new', [App\Http\Controllers\AdminArticleController::class, 'new'])->name('new');
        Route::GET('/{post}/edit', [App\Http\Controllers\AdminArticleController::class, 'new'])->name('edit');
        Route::PUT('/update/{post}', [App\Http\Controllers\AdminArticleController::class, 'update'])->name('update');
        Route::POST('/store', [App\Http\Controllers\AdminArticleController::class, 'store'])->name('store');
        Route::GET('/json', [App\Http\Controllers\AdminArticleController::class, 'json']);
    });

    Route::prefix('category')->name('category.')->group(function () {

        Route::PUT('/update/{post}', [App\Http\Controllers\AdminCategoryController::class, 'update'])->name('update');
        Route::POST('/store', [App\Http\Controllers\AdminCategoryController::class, 'store'])->name('store');
        Route::DELETE('/delete/{id}', [App\Http\Controllers\AdminCategoryController::class, 'destroy'])->name('destroy');
        Route::GET('/find/{id}', [App\Http\Controllers\AdminCategoryController::class, 'find']);

        //In Article Page
        Route::GET('/store/quick', [App\Http\Controllers\AdminCategoryController::class, 'storeJson'])->name('storeJson');
        Route::GET('/json', [App\Http\Controllers\AdminCategoryController::class, 'json']);
    });

    Route::prefix('tag')->name('tag.')->group(function () {

        Route::PUT('/update/{post}', [App\Http\Controllers\AdminTagsController::class, 'update'])->name('update');
        Route::POST('/store', [App\Http\Controllers\AdminTagsController::class, 'store'])->name('store');
        Route::DELETE('/delete/{id}', [App\Http\Controllers\AdminTagsController::class, 'destroy'])->name('destroy');
        Route::GET('/find/{id}', [App\Http\Controllers\AdminTagsController::class, 'find']);

        //In Article Page
        Route::GET('/store/quick', [App\Http\Controllers\AdminTagsController::class, 'storeJson'])->name('storeJson');
        Route::GET('/json', [App\Http\Controllers\AdminTagsController::class, 'json']);
    });
});
