<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'acController@index');
Route::post('/', 'acController@submitController');

Route::get('/passreset', 'acController@passreset');
Route::post('/passreset', 'acController@resetsubmit');

Route::get('/todo/{user_id}', 'todoController@index')->name('todo.index');
Route::post('/todo/{user_id}', 'todoController@submit');
