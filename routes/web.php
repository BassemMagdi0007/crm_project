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
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

//user routes
Route::get('/create/user','AdminController@create')->name('user.create');
Route::post('/create/user','AdminController@store')->name('user.store');
