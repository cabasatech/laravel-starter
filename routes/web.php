<?php

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

Route::get(
    '/', function () {
        return view('welcome');
    }
);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tasks', 'TaskController@index')->name('tasks');
Route::get('/task/create', 'TaskController@create')->name('task.create');
Route::post('/task', 'TaskController@store')->name('task.store');
Route::get('/task/{task}', 'TaskController@show')->name('task.show');
Route::get('/task/{task}/edit', 'TaskController@edit')->name('task.edit');
Route::match(
    ['PUT', 'PATCH'], '/task/{task}', 'TaskController@update'
)->name('task.update');
Route::get('/task/{task}/delete', 'TaskController@destroy')->name('task.destroy');