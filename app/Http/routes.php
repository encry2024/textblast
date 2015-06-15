<?php

# BIND
Route::bind('recipient', 		function( $id ) 	{ return App\Recipient::find($id); });
//Route::bind('team', 			function( $id ) 	{ return App\Team::find($id); });
//Route::bind('sms', 				function( $id )		{ return App\Sms::find($id); });
Route::bind('recipientTeam', 	function( $id ) 	{ return App\RecipientTeam::find($id); });
Route::bind('recipientNumber', 	function( $id ) 	{ return App\RecipientNumber::find($id); });
Route::bind('template', 		function( $id )		{ return App\Template::find($id); });

# RESOURCES
Route::resource('recipient', 'RecipientController', [ 'except' => ['create'] ]);
Route::resource('recipientNumber', 'RecipientNumberController', [ 'only' => ['store','update','destroy'] ]);
Route::resource('sms', 'SmsController', [ 'only'  =>  ['index', 'edit', 'store'], ]);
Route::resource('team', 'TeamController');
//Route::post('tag/recipient', ['as' => 'tr', 'uses' => 'RecipientTeamController@tag']);
Route::post('delete/recipient', ['as' => 'dr', 'uses' => 'RecipientTeamController@deleteRecipient']);
Route::resource('recipientTeam', 'RecipientTeamController');
Route::resource('template', 'TemplateController', ['only' => ['store', 'update', 'show']]);

# POST
Route::post('sms/send', ['as' => 'sendsms', 'uses' => 'SmsController@send']);
Route::get('sms/resend/{smsactivity}', ['as' => 'resendsms', 'uses' => 'SmsActivityController@resend']);

# CONTROLLERS
Route::controllers(array('auth' => 'Auth\AuthController','password' => 'Auth\PasswordController', ));

# GET
Route::get('/', ['as' => '/home', 'uses' => 'SmsController@inbox']);
Route::get('contacts', ['as'  => 'pb', 'uses' => function() {return view('contacts.show');}]);
Route::get('groups', ['as' => 'grp', 'uses' => function() {return view('groups.show');}]);
Route::get('test', function() {return view('tests.testform');});
Route::get('messaging', ['as' => 'msg', 'uses' => 'SmsController@retSmsCount']);
Route::get('template/{template_id}', ['as' => 'req_temp', 'uses' => 'TemplateController@show']);
Route::any('stats/sms', ['uses' => 'StatsController@dailySms']);
Route::any('sms/{sms}/views', ['uses' => 'SmsController@views']);
Route::get('sms/inbox', ['uses' => 'SmsController@inbox']);
Route::get('sms/outbox', ['uses' => 'SmsController@outbox']);
Route::get('sms/sent', ['uses' => 'SmsController@sent']);
Route::get('sms/failed', ['uses' => 'SmsController@failed']);

# POST
Route::post('team/{id}/untag', ['as' => 'untag', 'uses' => 'TeamController@untagRecipient']);

//Route::post('retrieve/{template}',);

# JSON
Route::get('getNum', 'RecipientNumberController@getNumber');
Route::get('retrieve/contacts', 'SmsController@retrieveSms');
Route::get('retrieve/recipients','SmsController@retrieveRecipient');
Route::get('sent_sms', 'SmsController@getSent');

Route::get('recipients/json', 'RecipientController@getAllRecipientsJSON');
Route::get('mobile-numbers/json', 'RecipientNumberController@getAllRecipientNumbersJSON');
Route::get('teams/json', 'TeamController@getAllTeamsJSON');
Route::get('sms/status/{status}', 'SmsController@getSmsByStatusJSON');
