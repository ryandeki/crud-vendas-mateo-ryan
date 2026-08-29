<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');