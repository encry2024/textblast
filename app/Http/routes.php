<?php

#------------------------------------------------------------ BIND
Route::bind('recipient', function( $id ) 		{ return App\Recipient::find($id); });
Route::bind('team', function( $id ) 			{ return App\Team::find($id); });
Route::bind('sms', function()		 			{ return App\Sms::all(); });
Route::bind('recipientTeam', function( $id ) 	{ return App\RecipientTeam::find($id); });
Route::bind('recipientNumber', function( $id ) 	{ return App\RecipientNumber::find($id); });
#------------------------------------------------------------ RESOURCES
Route::resource('recipient', 'RecipientController', [ 'except' => ['edit','create'] ]);
Route::resource('recipientNumber', 'RecipientNumberController', [ 'only' => ['store','update','destroy'] ]);
Route::resource('sms', 'SmsController', [ 'only'  =>  ['index', 'store'], ]);
Route::resource('team', 'TeamController');
Route::post('tag/recipient', ['as' => 'tr', 'uses' => 'RecipientTeamController@tag']);
Route::post('delete/recipient', ['as' => 'dr', 'uses' => 'RecipientTeamController@deleteRecipient']);
Route::resource('recipientTeam', 'RecipientTeamController');
#------------------------------------------------------------ CONTROLLERS
Route::controllers(array(
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
));
#------------------------------------------------------------ GET
// HOME
Route::get('/', ['as' => '/home', 'uses' => 'HomeController@index']);
// CONTACTS
Route::get('contacts', ['as'  => 'pb', 'uses' => function() {
	    return view('contacts.show');
}]);
// GROUPS
Route::get('groups', ['as' => 'grp', 'uses' => function() {
	return view('groups.show');
}]);
// FOR TEST PURPOSES ONLY
Route::get('test', function() {
	return view('tests.testform');
});
//SMS
Route::get('messaging', ['as' => 'msg', 'uses' => 'SmsController@retSmsCount']);
#------------------------------------------------------------ JSON
Route::get('getNum', 'RecipientNumberController@getNumber');
Route::get('retrieve/contacts', 'SmsController@retrieveSms');
Route::get('retrieve/recipients','SmsController@retrieveRecipient');
Route::get('sent_sms', 'SmsController@getSent');