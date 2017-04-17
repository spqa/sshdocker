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

Route::get('/','IndexController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/container/add', 'IndexController@add')->name('container.add');
Route::get('/container/start/{id}', 'IndexController@start_container')->name('container.start');
Route::get('/container/delete/{id}', 'IndexController@delete_container')->name('container.delete');
Route::post('/container/add', 'IndexController@create_container')->name('container.create');

