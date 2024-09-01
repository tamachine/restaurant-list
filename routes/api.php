<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;

Route::get('/', [RestaurantController::class, 'index']);
Route::post('/update-list', [RestaurantController::class, 'updateList']);
Route::get('/get/{id}', [RestaurantController::class, 'show']);
