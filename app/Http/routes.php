<?php

Route::bind('recipient', function( $id ) {
    return App\Recipient::find($id);
});

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

get('/', ['as' => '/home', 'uses' => 'HomeController@index']);
get('phonebook', ['as'  => 'pb', 'uses' => 'RecipientController@index']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
