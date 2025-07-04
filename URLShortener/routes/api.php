<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shorturlController;

Route::post('/shorten', [shorturlController::class, 'shorten']);

