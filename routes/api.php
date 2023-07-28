<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TransactionController;

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

/* user & authentication */
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);   

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* transaction */
Route::get('transaction', [TransactionController::class, 'index']);  // show all transaction
Route::get('transaction/{id}', [TransactionController::class, 'show']); // show specified transaction by id
Route::post('transaction', [TransactionController::class, 'store']); // create new transaction
Route::post('transaction/update/{id}', [TransactionController::class, 'update']); // update transaction
Route::delete('transaction/delete/{id}', [TransactionController::class, 'destroy']); //delete specified transaction
Route::put('/transaction/{id}/status', [TransactionController::class, 'changeTransactionStatus']); // change transaction status
Route::get('/transaction/month/{month}/{year}', [TransactionController::class, 'showTransactionByMonth']); //show transaction by month of its date

/* category */
