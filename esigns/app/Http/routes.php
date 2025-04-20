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

Route::get('/', 'WelcomeController@index');
// Route::get('login', 'WelcomeController@index');
Route::any('login', function(){
	return redirect()->away('https://i-practice.co.uk/login');
});

Route::any('auth/login', function(){
	return redirect()->away('https://i-practice.co.uk/login');
});

Route::get('home', 'HomeController@index');
Route::get('delete/{id}', 'HomeController@deleteDoc');

Route::get('upload', 'CreateSignController@index');

Route::post('uploadFile', 'CreateSignController@upload');

Route::post('createSignDoc', 'CreateSignController@createSign');

// guest sign 
Route::get('passcode/{key}', 'SignDocController@index');
Route::post('passcode/{key}', 'SignDocController@verifyPasscode');
Route::get('signit', 'SignDocController@signDocument');
Route::post('makesign', 'SignDocController@makeSign');
Route::get('declinetosign', 'SignDocController@declineSign');
Route::post('personalSign', 'SignDocController@personalSign');

Route::controllers([
	'auth' => 'Auth\AuthController',
]);

Route::get('gateway/{token}/{name}/{email}/{pname}', 'WelcomeController@authuser');

