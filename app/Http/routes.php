<?php
#------------------------------------------------------------ RECIPIENT
Route::bind('recipients', function( $id ) {
	return App\Recipient::find($id)->first();
});

Route::resource('recipients', 'RecipientController', [
	'names' =>  [
		'index'     =>  'recipients',
		'store'    =>  'recipient/store',
        'show'     =>  'recipient/show',
	],
]);

#-------------------------------------------------------------- INBOX
Route::bind('inbox', function() {
	return App\Inbox::all();
});

Route::resource('inbox', 'InboxController', [
	'only'  =>  ['index'],
]);

#--------------------------------------------------------------- Admin Route Controller
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



#---------------------------------------------------------------- GET

get('/', ['as' => '/home', 'uses' => 'HomeController@index']);

get('contacts', ['as'  => 'pb', 'uses' => function() {
	    return view('contacts.show');
}]);




#---------------------------------------------------------------- POST


