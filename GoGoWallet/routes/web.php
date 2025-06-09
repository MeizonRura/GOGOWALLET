<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', 'UserController@index');           // Endpoint 1: List user
Route::get('/users/{id}', 'UserController@show');       // Endpoint 2: Detail user
Route::post('/users', 'UserController@store');          // Endpoint 3: Tambah user
Route::put('/users/{id}', 'UserController@update');     // Endpoint 4: Update user
Route::delete('/users/{id}', 'UserController@destroy'); // Endpoint 5: Hapus user
