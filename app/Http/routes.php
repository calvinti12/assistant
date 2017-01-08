<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/hook','Hook@index');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/prappo','Run@test');
Route::auth();
Route::get('/profile','ProfileController@index');
Route::post('/profile','ProfileController@update');
Route::get('/facebook/connect','FacebookController@fbConnect');
Route::post('/getexmsg','SettingsController@getExMessage');
Route::get('/spam/logs','SpamController@logs');
Route::post('/spam/deleteall','SpamController@deleteLogs');
Route::resource('/facebook','FacebookController');
Route::resource('/settings','SettingsController');
Route::resource('/comment','Comments');
Route::resource('/message','Messages');
Route::resource('/spam','SpamController');
Route::resource('/code','ShortCodeController');
Route::resource('/notification','NotificationController');
Route::resource('/spam','SpamController');
Route::get('/home', 'HomeController@index');
