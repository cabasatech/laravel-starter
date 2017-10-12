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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get(
    '/tasks', 'TaskController@index'
);
Route::get(
    '/task/create', 'TaskController@create'
);
Route::post(
    '/task', 'TaskController@store'
);
Route::get(
    '/task/{task}', 'TaskController@show'
)->name('showTask');
Route::get(
    '/task/{task}/edit', 'TaskController@edit'
);
Route::match(['PUT', 'PATCH'], 
    '/task/{task}', 'TaskController@update'
)->name('updateTask');
Route::delete(
    '/task/{task}', 'TaskController@destroy'
);
