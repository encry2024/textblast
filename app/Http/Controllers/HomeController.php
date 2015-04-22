<?php namespace App\Http\Controllers;

use App\Recipient;
use App\Inbox;
use App\Team;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * @param Recipient $recipient
	 * @param Inbox $inbox
	 * @param Team $team
	 * @return \Illuminate\View\View
	 */
	public function index( Recipient $recipient, Inbox $inbox, Team $team )
	{
        $recipients = $recipient->all();
        $inbox 		= $inbox->all();
		$team		= $team->all();

		return view('home', compact('recipients', 'inbox', 'team'));
	}

}
