<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/account', AccountController::class)->except(['create', 'edit']);
Route::resource('/category', CategoryController::class)->except(['create', 'edit']);
Route::resource('/pemasukanpending', PemasukanPendingController::class)->except(['create', 'edit']);
Route::resource('/pemasukanverified', PemasukanVerifiedController::class)->except(['create', 'edit']);
Route::resource('/pengeluaran', PengeluaranController::class)->except(['create', 'edit']);