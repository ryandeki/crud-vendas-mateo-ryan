<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/new-category', [MainController::class, 'newCategory'])->name('new');
    Route::post('/newCategorySubmit', [MainController::class, 'newCategorySubmit'])
    ->name('newCategorySubmit');
    Route::get('/edit-category/{id}', [MainController::class, 'editCategory'])->name('edit');
    Route::post('/edit-category-submit', [MainController::class, 'editCategorySubmit'])->name('edit.category.submit');
    Route::get('/delete-category/{id}', [MainController::class, 'deleteCategory'])->name('delete');
    Route::get('/delete-category-confirm/{id}', [MainController::class, 'deleteCategoryConfirm'])->name('delete.category.confirm');
    Route::get('/category-page/{id}', [MainController::class, 'toAccessCategory'])->name('category.page');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
});