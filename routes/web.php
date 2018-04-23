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



Route::resource('posts','PostController');

/*
Route::get('posts','PostController@index');
Route::delete('posts/{id}','PostController@destroy');
Route::get('/posts/{id}/edit','PostController@edit');
Route::patch('posts/{id}','PostController@update');
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


