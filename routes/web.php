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
Route::get('/show/users/{role}','UsersController@index')->name('user.all');
//profile routes
Route::get('/changepassword','UsersController@ChangeForm')->name('profile.change.form');
Route::put('/ChangePassword','UsersController@ChangePassword')->name('password.change');

//complain routes
Route::get('/complain/create','ComplainController@create')->name('complain.create');
Route::post('/complain/store','complaincontroller@store')->name('complain.store');
Route::get('complain/show/{id}','complaincontroller@show')->name('complain.details');
Route::get('complain/all/{state}','complaincontroller@index')->name('complain.all');
Route::put('/complain/sign','complaincontroller@sign')->name('complain.sign');


//Reply routes
Route::post('/reply/store','ReplyController@store')->name('reply.store');


