<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RecipientTeam;
use App\Team;
use Illuminate\Http\Request;

use App\Http\Requests\CreateRecipientTeamRequest;

class RecipientTeamController extends Controller {


	/**
	 * @param RecipientTeam $recipientTeam
	 * @param Team $team
	 */
	public function __constructor( RecipientTeam $recipientTeam,
								   Team $team) {
		$this->recipientTeam = $recipientTeam;
		$this->team = $team;
	}

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * @param Team $team
	 * @param CreateRecipientTeamRequest $crtp
	 * @param RecipientTeam $recipientTeam
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( CreateRecipientTeamRequest $crtp,
						   RecipientTeam $recipientTeam, Team $team ) {

		$rt_id = $recipientTeam->create( $crtp->request->all() );

		$team_id = $rt_id->team_id;

		$tm = $team->find($team_id);

		return redirect()->back()->with('success_msg', 'Recipient was successfully tagged to the Group:'.$tm->name.'.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  RecipientTeam $rcptTeam
	 * @return Response
	 */
	public function update(RecipientTeam $rcptTeam)  {
		return Input::get('grp_id');
	}

	/**
	 * Remove the specified resource from storage.
	 * @param Request $request
	 * @return Response
	 */
	public function destroy( Request $request ) {
		$untag_rcptTeam = RecipientTeam::find( $request->get('team_id') );
		$untag_rcptTeam->delete();

		return redirect()->back()->with('success_msg', 'Recipient was successfully untagged.');
	}
}
