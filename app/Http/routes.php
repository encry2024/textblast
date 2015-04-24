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
        'update'   	=>  'recipient.update',
		'edit'		=>	'recipient.edit',
		'delete'	=>	'recipient.destroy'
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
		'destroy' => 'recipientTeam.destroy',
		'update' => 'team/update'
	],
]);

#-------------------------------------------------------------- RECIPIENT NUMBER
Route::bind('recipientNumber', function( $id ) {
	return App\RecipientNumber::find($id);
});

Route::resource('recipientNumber', 'RecipientNumberController', [
	'names'  =>  [
		'store'	=>	'recipientNumber.store',
		'update' => 'contact/update',
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

Route::post('untag', function() {
	$untag_rcptTeam = App\RecipientTeam::find( Input::get('team_id') );
	$untag_rcptTeam->delete();

	return redirect()->back()->with('success_msg', 'Recipient was successfully untagged.');
});

Route::post('delete/contact', function() {
	$del_contact = App\RecipientNumber::find( Input::get('num_id') );
	$del_contact->delete();

	return redirect()->back()->with('success_msg', "Recipient's contact was successfully deleted.");
});