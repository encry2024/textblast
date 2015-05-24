<?php namespace App\Http\Controllers;

use App\Http\Requests;
# MODEL
use App\Team;
# REQUESTS
use App\Http\Requests\CreateTeamRequest;
# INPUT
use Illuminate\Support\Facades\Input;

class TeamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param Team $team
	 */
	protected $team;

    public function __construct(Team $team) {
		// Add auth filter
		$this->middleware('auth');

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
	public function show() {
		return view('groups.edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		return view('groups.edit', compact('id'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		//$affectedRows = User::where('votes', '>', 100)->update(['status' => 2]);
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

}
