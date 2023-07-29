<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

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

/* user & authentication & passport */
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    /* users */
    Route::get('user', [AuthController::class, 'index']);
    Route::get('user/{id}', [AuthController::class, 'show']); // show specified userby id
    Route::post('user/update/{id}', [AuthController::class, 'update']); // update user
    Route::delete('user/delete/{id}', [AuthController::class, 'destroy']); //delete specified user

    /* transaction */
    Route::get('transaction', [TransactionController::class, 'index']);  // show all transaction
    Route::get('transaction/{id}', [TransactionController::class, 'show']); // show specified transaction by id
    Route::post('transaction', [TransactionController::class, 'store']); // create new transaction
    Route::post('transaction/update/{id}', [TransactionController::class, 'update']); // update transaction
    Route::delete('transaction/delete/{id}', [TransactionController::class, 'destroy']); //delete specified transaction
    Route::put('/transaction/{id}/status', [TransactionController::class, 'changeTransactionStatus']); // change transaction status
    Route::get('/transaction/month/{month}/{year}', [TransactionController::class, 'showTransactionByMonth']); //show transaction by month of its date
    
    /* Category */
    Route::get('category', [CategoryController::class, 'index']);  // show all transaction
    Route::post('category', [CategoryController::class, 'store']); // create new transaction
    Route::post('category/update/{id}', [CategoryController::class, 'update']); // update transaction
    Route::delete('category/delete/{id}', [CategoryController::class, 'destroy']); //delete specified transaction

});

