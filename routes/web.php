<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');

    Route::get('/trash-items', [MainController::class, 'trashItems'])->name('trash.items');
    Route::get('/items', [MainController::class, 'items'])->name('items');
    Route::get('/new-item', [MainController::class, 'newItem'])->name('newItem');
    Route::post('newItemSubmit', [MainController::class, 'newItemSubmit'])->name('newItemSubmit');
    Route::get('edit-item/{id}', [MainController::class, 'editItem'])->name('edit.item');
    Route::post('edit-item-submit', [MainController::class, 'editItemSubmit'])->name('edit.item.submit');
    Route::get('delete-item/{id}', [MainController::class, 'deleteItem'])->name('deleteItem');
    Route::get('delete-item-confirm/{id}', [MainController::class, 'deleteItemConfirm'])->name('delete.item.confirm');
    Route::get('restore-item/{id}', [MainController::class, 'restoreItem'])->name('restore.item');
    Route::get('item-page/{id}', [MainController::class, 'toAccessItemPage'])->name('item.page');

    Route::get('/categories', [MainController::class, 'categories'])->name('categories');
    Route::get('/new-category', [MainController::class, 'newCategory'])->name('new');
    Route::post('/newCategorySubmit', [MainController::class, 'newCategorySubmit'])
        ->name('newCategorySubmit');
    Route::get('/edit-category/{id}', [MainController::class, 'editCategory'])->name('edit');
    Route::post('/edit-category-submit', [MainController::class, 'editCategorySubmit'])->name('edit.category.submit');
    Route::get('/delete-category/{id}', [MainController::class, 'deleteCategory'])->name('delete');
    Route::get('/delete-category-confirm/{id}', [MainController::class, 'deleteCategoryConfirm'])->name('delete.category.confirm');
    Route::get('/category-page/{id}', [MainController::class, 'toAccessCategory'])->name('category.page');

    Route::get('/user', [MainController::class, 'toUserPage'])->name('user.page');
    Route::get('/user/edit', [MainController::class, 'toEditUserPage'])->name('user.edit.page');
    Route::post('/user/edit/confirm', [MainController::class, 'editUserConfirm'])->name('user.edit.confirm');
    Route::get('/user/edit/adress/', [MainController::class, 'toEditAdressPage'])->name('user.adress.page');
    Route::post('/user/edit/adress/confirm', [MainController::class, 'editAdressConfirm'])->name('user.adress.confirm');
    Route::post('/user/adress/cep', [MainController::class, 'findCep'])->name('cep');

    Route::get('/new-review/{id}', [MainController::class, 'newReview'])->name('newReview');
    Route::post('/newReviewSubmit', [MainController::class, 'newReviewSubmit'])->name('newReviewSubmit');
    Route::get('/delete-review/{id}', [MainController::class, 'deleteReview'])->name('deleteReview');
    Route::get('/delete-review-confirm/{id}', [MainController::class, 'deleteReviewConfirm'])->name('delete.review.confirm');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');

    Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
    Route::post('/signin-submit', [AuthController::class, 'signinSubmit'])->name('signin.submit');
});