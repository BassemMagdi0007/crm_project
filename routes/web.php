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

Auth::routes(['register'=>false]);
//home routes
Route::get('/',function (){return redirect()->route('home');});
Route::get('/home', 'HomeController@index')->name('home');

//user routes
Route::get('/create/user','UsersController@create')->name('user.create');
Route::post('/create/user','UsersController@store')->name('user.store');
Route::get('/show/user/profile/{id}','UsersController@show')->name('user.data');
Route::get('/show/users/{role}','UsersController@index')->name('user.all');
Route::delete('/user/delete','UsersController@destroy')->name('user.delete');
//profile routes
Route::get('/changepassword','UsersController@ChangeForm')->name('profile.change.form');
Route::put('/ChangePassword','UsersController@ChangePassword')->name('password.change');
Route::get('/edit/profile','UsersController@edit')->name('edit.profile');
Route::put('/update/profile','UsersController@update')->name('profile.update');
//complain routes
Route::get('/complain/create','ComplainController@create')->name('complain.create');
Route::post('/complain/store','complaincontroller@store')->name('complain.store');
Route::get('complain/show/{id}','complaincontroller@show')->name('complain.details');
Route::get('complain/all/{state}','complaincontroller@index')->name('complain.all');
Route::put('/complain/sign','complaincontroller@sign')->name('complain.sign');
Route::put('/unsolved','ComplainController@unsolved')->name('unsolved');
Route::put('/solved','ComplainController@solved')->name('solved');

//Reply routes
Route::post('/reply/store','ReplyController@store')->name('reply.store');
Route::get('/replies/active','ReplyController@activeReplies')->name('reply.active');
Route::get('/replies/history','ReplyController@historyReplies')->name('reply.history');
//Rate routes
Route::post('/rate/view','RateController@Rateview')->name('rate.view');
Route::post('/rate','RateController@rate')->name('rate');
Route::get('/system/rates','RateController@systemRates')->name('system.rates');