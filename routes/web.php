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

Route::get('/', 'HomeController@index')->name('home');
Route::get('user', 'InstagramController@index')->name('user-page');
Route::get('instagram-user-pagination','InstagramController@pagination')->name('instagram-user-pagination');
Route::post('download','InstagramController@download');
