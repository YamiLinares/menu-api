<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'menu');
Route::view('/docs', 'docs');
Route::get('/postman/collection', fn () => response()->download(base_path('docs/postman/La-Buena-Mesa.postman_collection.json')));
