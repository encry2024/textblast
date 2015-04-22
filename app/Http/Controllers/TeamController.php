<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Team;

class TeamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param Team $team
	 */
    public function __construct(Team $team) {
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		//
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		//
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
