<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EkgController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('patients', PatientController::class);
Route::resource('ekg', EkgController::class);
Route::get('/ekg/download/{id}', [EkgController::class, 'download'])->name('ekg.download');