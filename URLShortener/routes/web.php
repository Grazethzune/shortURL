<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shorturlController;

Route::view('/', 'urlshorter');
Route::get('/stats', [shorturlController::class, 'stats']);
Route::get('/{code}', [shorturlController::class, 'redirect']);


