<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSVController;

Route::get('/', [CSVController::class, 'index'])->name('home');
Route::post('/upload-csv', [CSVController::class, 'store'])->name('upload-csv');
