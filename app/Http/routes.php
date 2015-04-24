<?php




#------------------------------------------------------------ BIND
Route::bind('recipient', function( $id ) 		{ return App\Recipient::find($id); });
Route::bind('team', function( $id ) 			{ return App\Team::find($id); });
Route::bind('sms', function()		 			{ return App\Sms::all(); });
Route::bind('recipientTeam', function( $id ) 	{ return App\RecipientTeam::find($id); });
Route::bind('recipientNumber', function( $id ) 	{ return App\RecipientNumber::find($id); });
#------------------------------------------------------------ RESOURCES
Route::resource('recipient', 'RecipientController', [ 'only' => ['index','store','show','update','destroy'] ]);
Route::resource('recipientNumber', 'RecipientNumberController', [ 'only' => ['store','update','destroy'] ]);
Route::resource('sms', 'SmsController', [ 'only'  =>  ['index'], ]);
Route::resource('team', 'TeamController', [ 'only' => ['index', 'store', 'show'] ]);
Route::resource('recipientTeam', 'RecipientTeamController', [ 'only' => ['store', 'destroy', 'update', 'untag'] ]);
#------------------------------------------------------------ CONTROLLERS
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
#---------------------------------------------------------------- GET
Route::get('/', ['as' => '/home', 'uses' => 'HomeController@index']);
Route::get('contacts', ['as'  => 'pb', 'uses' => function() {
	    return view('contacts.show');
}]);

Route::get('groups', ['as' => 'grp', 'uses' => function() {
	return view('groups.show');
}]);
