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

Auth::routes();
//home routes
Route::get('/',function (){return redirect()->route('home');});
Route::get('/home', 'HomeController@index')->name('home');

//user routes
Route::get('/create/user','UsersController@create')->name('user.create');
Route::post('/create/user','UsersController@store')->name('user.store');
Route::get('/show/user/profile/{id}','UsersController@show')->name('user.data');



