<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\timeController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', 'App\Http\Controllers\timecontroller@index');
Route::post('/', 'App\Http\Controllers\timecontroller@userSubmit');

Route::get('/register/', 'App\Http\Controllers\usercontroller@index');
Route::post('/register/', 'App\Http\Controllers\usercontroller@userRegister');

Route::get('/management/', 'App\Http\Controllers\managementcontroller@index');

Route::get('/past/', 'App\Http\Controllers\pastcontroller@index');
Route::post('/past/', 'App\Http\Controllers\pastcontroller@pastRegister');