<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ReservationController;

Route::apiResource('reservations', ReservationController::class);
Route::apiResource('contacts', ContactController::class);