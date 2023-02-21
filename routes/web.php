<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::controller(GuestController::class)->middleware('guest')
    ->as('guest.')
    ->group(function () {
        Route::get('/', 'index')->name('default');
        Route::get('/search', 'search')->name('search');
        Route::get('/search-ajax', 'searchAjax')->name('search-ajax');
        Route::get('/search-title', 'searchTitle')->name('search-title');
        Route::get('/book-detail/{book}', 'bookDetail')->name('book-detail');
        Route::get('/filter-data', 'ajaxGetFilterData')->name('filter-data');
    });

Auth::routes([
    'register' => false
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::controller(AuthorController::class)
    ->middleware('auth')
    ->prefix('authors')
    ->as('authors.')
    ->group(function () {
        Route::get('/', 'index')->name('default');
        Route::get('/datatables/', 'datatables')->name('datatables');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('delete');
    });

Route::controller(GenreController::class)
    ->middleware('auth')
    ->prefix('genres')
    ->as('genres.')
    ->group(function () {
        Route::get('/', 'index')->name('default');
        Route::get('/datatables/', 'datatables')->name('datatables');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('delete');
    });

Route::controller(PublisherController::class)
    ->middleware('auth')
    ->prefix('publishers')
    ->as('publishers.')
    ->group(function () {
        Route::get('/', 'index')->name('default');
        Route::get('/datatables/', 'datatables')->name('datatables');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('delete');
    });

Route::controller(BookController::class)
    ->middleware('auth')
    ->prefix('books')
    ->as('books.')
    ->group(function () {
        Route::get('/', 'index')->name('default');
        Route::get('/datatables/', 'datatables')->name('datatables');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/edit/{book}', 'edit')->name('edit');
        Route::post('/{book}', 'update')->name('update');
        Route::delete('/{book}', 'destroy')->name('delete');
    });
