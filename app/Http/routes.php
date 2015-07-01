<?php

# BIND
Route::bind('recipient', 		function( $id ) 	{ return App\Recipient::find($id); });
//Route::bind('team', 			function( $id ) 	{ return App\Team::find($id); });
//Route::bind('sms', 			function( $id )		{ return App\Sms::find($id); });
Route::bind('recipientTeam', 	function( $id ) 	{ return App\RecipientTeam::find($id); });
Route::bind('recipientNumber', 	function( $id ) 	{ return App\RecipientNumber::find($id); });
Route::bind('template', 		function( $id )		{ return App\Template::find($id); });
Route::bind('user',				function( $id )		{ return App\User::find($id); });
Route::bind('activity', 		function( $id )		{ return App\Activity::find($id); });

# RESOURCES
Route::resource('recipient', 'RecipientController', [ 'except' => ['create'] ]);
Route::resource('recipientNumber', 'RecipientNumberController', [ 'only' => ['store','update','destroy'] ]);
Route::resource('sms', 'SmsController', [ 'only'  =>  ['index', 'edit', 'store'], ]);
Route::resource('team', 'TeamController');
Route::resource('user', 'UserController');
Route::resource('recipientTeam', 'RecipientTeamController');
Route::resource('template', 'TemplateController', ['only' => ['store', 'update', 'show']]);
Route::resource('activity', 'ActivityController', ['only' => ['index']]);
//Route::post('tag/recipient', ['as' => 'tr', 'uses' => 'RecipientTeamController@tag']);


# AUTH CONTROLLERS
Route::controllers(array('auth' => 'Auth\AuthController','password' => 'Auth\PasswordController'));

# GET
Route::get('/', ['middleware' => 'auth.status', 'as' => '/home', 'uses' => 'SmsController@inbox']);
Route::get('home', ['middleware' => 'auth.status', 'uses' => 'SmsController@inbox']);
Route::get('contacts', ['as'  => 'pb', 'uses' => function() {return view('contacts.show');}]);
Route::get('groups', ['middleware' => 'auth.status', 'as' => 'grp', 'uses' => function() {return view('groups.show');}]);
Route::get('test', function() {return view('tests.testform'); });
Route::get('messaging', ['as' => 'msg', 'uses' => 'SmsController@retSmsCount']);
Route::get('template/{template_id}', ['as' => 'req_temp', 'uses' => 'TemplateController@show']);
Route::get('change_password', ['middleware' => 'auth.status', 'as' => 'change_password', 'uses' => 'UserController@viewChangePassword']);

# POST
Route::post('team/{id}/untag', ['as' => 'untag', 'uses' => 'TeamController@untagRecipient']);
Route::post('sms/send', ['as' => 'sendsms', 'uses' => 'SmsController@send']);
Route::post('sms/reply/{recipientnumber}', ['uses' => 'SmsController@reply']);
Route::post('sms/resend/{smsactivity}', ['as' => 'resendsms', 'uses' => 'SmsActivityController@resend']);
Route::post('delete/recipient', ['as' => 'dr', 'uses' => 'RecipientTeamController@deleteRecipient']);
Route::post('user/changed_password', ['as' => 'auth_cp', 'uses' => 'UserController@changePass']);

# JSON
Route::get('getNum', 'RecipientNumberController@getNumber');
Route::get('retrieve/contacts', 'SmsController@retrieveSms');
Route::get('retrieve/recipients','SmsController@retrieveRecipient');
Route::get('sent_sms', 'SmsController@getSent');

Route::get('recipients/json', 'RecipientController@getAllRecipientsJSON');
Route::get('mobile-numbers/json', 'RecipientNumberController@getAllRecipientNumbersJSON');
Route::get('teams/json', 'TeamController@getAllTeamsJSON');
Route::get('sms/status/{status}', 'SmsController@getSmsByStatusJSON');

Route::any('stats/sms', ['middleware' => 'auth.status', 'uses' => 'StatsController@dailySms']);
Route::any('sms/{sms}/views', ['middleware' => 'auth.status', 'uses' => 'SmsController@views']);
Route::get('sms/inbox', ['uses' => 'SmsController@inbox']);
Route::get('sms/outbox', ['uses' => 'SmsController@outbox']);
Route::get('sms/sent', ['uses' => 'SmsController@sent']);
Route::get('sms/failed', ['uses' => 'SmsController@failed']);
Route::any('sms/{sms}/received', ['uses' => 'SmsController@received']);
Route::get('fetch/users', ['as' => 'users', 'uses' => 'UserController@fetchUser']);
Route::get('fetch/status/{user_id}', ['as' => 'fetchStatus', 'uses' => 'UserController@fetch_status']);
Route::get('fetchHistory', ['as' => 'get_history', 'uses' => 'ActivityController@fetchHistory']);