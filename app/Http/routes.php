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
Route::resource('team', 'TeamController', [ 'only' => ['index', 'store', 'show'] ]);
Route::resource('recipientTeam', 'RecipientTeamController', [ 'only' => ['store', 'destroy', 'update', 'untag'] ]);
#------------------------------------------------------------ CONTROLLERS
Route::controllers(array(
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
));
#---------------------------------------------------------------- GET
Route::get('/', ['as' => '/home', 'uses' => 'HomeController@index']);
Route::get('contacts', ['as'  => 'pb', 'uses' => function() {
	    return view('contacts.show');
}]);

Route::get('groups', ['as' => 'grp', 'uses' => function() {
	return view('groups.show');
}]);

Route::get('test', function() {
	return view('tests.testform');
});

Route::get('messaging', ['as' => 'msg', 'uses' => function() {
	return view('sms.show');
}]);

Route::get('getNum', function() {
	$json = array();
	$getNum = \App\RecipientNumber::all();

	foreach ($getNum as $contact) {
		$json[] = [
			'number' => $contact->phone_number,
			'id'	 => $contact->id
		];
	}

	return json_encode($json);
});



Route::get('retrieve/contacts', function( ) {
	$ret = \App\Sms::retrieving();

	return $ret;
});