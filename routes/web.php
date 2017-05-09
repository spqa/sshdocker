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

Auth::routes();

Route::group(['middleware'=>'auth'],function (){
    Route::get('/','IndexController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/test', 'TestController@index');
    Route::get('/container/add', 'ContainerController@add')->name('container.add');
    Route::get('/container/index', 'ContainerController@index')->name('container.index');
    Route::get('/container/start/{id}', 'ContainerController@start_container')->name('container.start');
    Route::get('/container/delete/{id}', 'ContainerController@delete_container')->name('container.delete');
    Route::post('/container/sunfrog/{domain?}', 'ContainerController@change_sunfrog_id')->name('container.sunfrog.update');
    Route::get('/container/sunfrog/{domain?}', 'ContainerController@edit_sunfrog_id')->name('container.sunfrog.edit');
    Route::post('/container/add', 'ContainerController@create_container')->name('container.create');

//Controller vps route
    Route::get('/vps/index','VpsController@index')->name('vps.index');
    Route::get('/vps/create','VpsController@create')->name('vps.create');
    Route::get('/vps/reset/{id}','VpsController@reset_server')->name('vps.reset');
    Route::get('/vps/delete/{id}','VpsController@delete_server')->name('vps.delete');
    Route::get('/vps/detail/{id}','VpsController@show')->name('vps.show');
    Route::post('/vps/index','VpsController@store')->name('vps.store');
});


