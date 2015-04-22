<?php
#------------------------------------------------------------ RECIPIENT
Route::bind('recipient', function( $id ) {
	return App\Recipient::find($id);
});

Route::resource('recipient', 'RecipientController', [
	'names' =>  [
		'index'    	=>  'recipients',
		'store'    	=>  'recipient/store',
        'show'     	=>  'recipient/show',
        'update'   	=>  'recipient/update',
		'edit'		=>	'recipient.edit'
	],
]);

#-------------------------------------------------------------- INBOX
Route::bind('inbox', function() {
	return App\Inbox::all();
});

Route::resource('inbox', 'InboxController', [
	'only'  =>  ['index'],
]);

#-------------------------------------------------------------- TEAM
Route::bind('team', function( $id ) {
    return App\Team::find($id);
});

Route::resource('team', 'TeamController', [
    'names'  =>  [
		'index' => 'team',
		'store'	=> 'team.store',
	],
]);

#-------------------------------------------------------------- RECIPIENT TEAM
Route::bind('recipientTeam', function( $id ) {
	return App\RecipientTeam::find($id);
});

Route::resource('recipientTeam', 'RecipientTeamController', [
	'names'  =>  [
		'index' => 'recipientTeam',
		'store'	=> 'recipientTeam.store',
	],
]);

#--------------------------------------------------------------- ADMIN ROUTE CONTROLLER
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


#---------------------------------------------------------------- POST


