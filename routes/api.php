<?php

use App\Http\Controllers\Api\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::get('/menu-items/category/{category}', [MenuItemController::class, 'category'])->name('menu-items.category');
Route::apiResource('menu-items', MenuItemController::class);
