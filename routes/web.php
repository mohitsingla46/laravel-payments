<?php

use App\Http\Controllers\PaymentController;
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

Route::get('/', [PaymentController::class, 'index']);
Route::get('add_card', [PaymentController::class, 'add_card']);
Route::post('save_card', [PaymentController::class, 'save_card']);
Route::post('remove_card', [PaymentController::class, 'remove_card']);
Route::post('doPayment', [PaymentController::class, 'doPayment']);
Route::get('delete_card/{id}', [PaymentController::class, 'delete_card']);
