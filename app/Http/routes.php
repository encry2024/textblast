<?php

# BIND
Route::bind('recipient', function( $id ) 		{ return App\Recipient::find($id); });
//Route::bind('team', function( $id ) 			{ return App\Team::find($id); });
Route::bind('sms', function( $id )		 		{ return App\Sms::find($id); });
Route::bind('recipientTeam', function( $id ) 	{ return App\RecipientTeam::find($id); });
Route::bind('recipientNumber', function( $id ) 	{ return App\RecipientNumber::find($id); });

# RESOURCES
Route::resource('recipient', 'RecipientController', [ 'except' => ['create'] ]);
Route::resource('recipientNumber', 'RecipientNumberController', [ 'only' => ['store','update','destroy'] ]);
Route::resource('sms', 'SmsController', [ 'only'  =>  ['index', 'edit', 'store'], ]);
Route::resource('team', 'TeamController');
//Route::post('tag/recipient', ['as' => 'tr', 'uses' => 'RecipientTeamController@tag']);
Route::post('delete/recipient', ['as' => 'dr', 'uses' => 'RecipientTeamController@deleteRecipient']);
Route::resource('recipientTeam', 'RecipientTeamController');

# POST
Route::post('sms/send', ['as' => 'sendsms', 'uses' => 'SmsController@send']);

# CONTROLLERS
Route::controllers(array('auth' => 'Auth\AuthController','password' => 'Auth\PasswordController', ));

# GET
Route::get('/', ['as' => '/home', 'uses' => 'HomeController@index']);
Route::get('contacts', ['as'  => 'pb', 'uses' => function() {return view('contacts.show');}]);
Route::get('groups', ['as' => 'grp', 'uses' => function() {return view('groups.show');}]);
Route::get('test', function() {return view('tests.testform');});
Route::get('messaging', ['as' => 'msg', 'uses' => 'SmsController@retSmsCount']);
Route::post('team/{id}/untag', ['as' => 'untag', 'uses' => 'TeamController@untagRecipient']);

# JSON
Route::get('getNum', 'RecipientNumberController@getNumber');
Route::get('retrieve/contacts', 'SmsController@retrieveSms');
Route::get('retrieve/recipients','SmsController@retrieveRecipient');
Route::get('sent_sms', 'SmsController@getSent');

Route::get('recipients/json', 'RecipientController@getAllRecipientsJSON');
Route::get('mobile-numbers/json', 'RecipientNumberController@getAllRecipientNumbersJSON');
Route::get('teams/json', 'TeamController@getAllTeamsJSON');