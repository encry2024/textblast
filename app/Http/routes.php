<?php
#---------------------------------------------- RECIPIENT
Route::bind('recipient', function( $id ) {
    return App\Recipient::find($id);
});

Route::resource('recipient', 'RecipientController', [
    'names' =>  [
        'index'     =>  'recipients',
        'create'    =>  'recipient/create',
    ],
]);

#----------------------------------------------- INBOX
Route::bind('inbox', function() {
    return App\Inbox::all();
});

Route::resource('inbox', 'InboxController', [
    'only'  =>  ['index'],
]);

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
get('contacts', ['as'  => 'pb', 'uses' => function() {
    return view('recipient.create');
}]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
