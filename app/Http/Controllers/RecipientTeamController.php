<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\RecipientTeam;
use App\Team;
use App\Recipient;
use Illuminate\Http\Request;

use App\Http\Requests\CreateRecipientTeamRequest;

class RecipientTeamController extends Controller {


	/**
	 * @param RecipientTeam $recipientTeam
	 * @param Team $team
	 */
	public function __constructor( RecipientTeam $recipientTeam,
								   Team $team) {
		// Add auth filter
		$this->middleware('auth.status');

		$this->recipientTeam = $recipientTeam;
		$this->team = $team;
	}

	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
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

		Recipient::find($crtp->get('recipient_id'))->touch();
		return redirect()->back()->with('success_msg', 'Recipient was successfully tagged to the Group:'.$tm->name.'.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
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
		$untag_rcptTeam = RecipientTeam::where('recipient_id', $request->get('recipient_id'))->where('team_id', $request->get('team_id'))->first();
		$untag_rcptTeam->delete();

		return redirect()->back()->with('success_msg', 'Recipient was successfully untagged.');
	}

	/**
	 * @param Request $request
	 * @return array
	 */
	public function tag(CreateTagRecipientRequest $request) {
		$tag_recipient = RecipientTeam::tagRecipient($request);

		return $tag_recipient;
	}

	public function deleteRecipient(Request $request) {
		$untag_rcptTeam = RecipientTeam::where('recipient_id', $request->get('recipient_id') )->first();
		$untag_rcptTeam->delete();

		return redirect()->back()->with('success_msg', 'Recipient was successfully untagged.');
	}
}
