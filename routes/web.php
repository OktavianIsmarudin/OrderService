<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderUIController;

Route::get('/', [OrderUIController::class, 'index']);
Route::get('/orders', [OrderUIController::class, 'listOrders']);
Route::post('/orders', [OrderUIController::class, 'storeOrder']);

