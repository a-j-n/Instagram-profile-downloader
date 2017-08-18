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
Route::get('user/{username}', 'InstagramController@index');

Route::get('test', function () {

    $url = "https://instagram.fcai2-1.fna.fbcdn.net/t51.2885-19/s150x150/20347662_463636264003263_7639995410760597504_a.jpg";
    $filename = basename($url);
    response()->download($url, $filename);


});