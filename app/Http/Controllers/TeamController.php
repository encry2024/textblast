<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Recipient;
use Illuminate\Http\Request;
# MODEL
use App\Team;
# REQUESTS
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
# INPUT
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
class TeamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param Team $team
	 */
	protected $team;

    public function __construct(Team $team) {
		// Add auth filter
		$this->middleware('auth.status');

        $this->team = $team;
    }

	/**
	 * @return string
	 */
	public function index() {
        $json = array();
        $teams = $this->team->get();
        foreach ($teams as $team) {
            $json[] = array(
                'id' 				=> $team->id,
                'name' 				=> $team->name,
				'description'		=> str_limit($team->description, $limit = 35, $end = '...'),
                'recent_updates'    => date('F d, Y [ h:i A D ]', strtotime($team->updated_at)),
            );
        }
        return json_encode($json);
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
	 * @param CreateTeamRequest $team_request
	 * @param Team $team
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store( CreateTeamRequest $team_request, Team $team ) {
		$t_r = $team->create( $team_request->request->all() );

		$team_name = $t_r->name;

		return redirect()->back()->with('success_msg', 'Team:'.$team_name.' was successfully saved.');
	}

	/**
	 * Display the specified resource.
	 * @return Response
	 */
	public function show(Team $team) {
		return view('groups.edit', compact('team'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Team $team) {
		return view('groups.edit', compact('team'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Team $team, UpdateTeamRequest $requests) {
		//update description
		$team->description = $requests->description;
		$team->save();

		if($requests->receivers) $team->recipients()->sync($requests->receivers, false);

		return redirect()->back()->with('success_msg', 'Success.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}


	/**
	 * @param
	 */
	public function untagRecipient($teamID, Request $request){
		// detach the given recipient id from the team
		Team::find($teamID)->recipients()->detach([$request->get('recipient_id')]);

		return redirect()->back()->with('success_msg', 'Success.');
	}

	/**
	 * @param
	 */
	public function getAllTeamsJSON(){
		return Team::all()->lists('name', 'id');
	}
}
