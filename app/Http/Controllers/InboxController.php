<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Inbox;
use App\Recipient;
use App\Team;

class InboxController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * return Response
	 */
    public function __construct(Inbox $inbox, Recipient $recipient, Team $team) {
        $this->inbox = $inbox;
        $this->recipient = $recipient;
        $this->team = $team;
    }

	public function index()
	{
        $json = array();
        $inboxes = $this->inbox->get();

        foreach ($inboxes as $inbox) {
            $rcpnts = $this->recipient->find($inbox->recipient_id)->first();
            $groups = $this->team->find($inbox->recipient_team_id)->first();

            $json[] = array(
                'recipient_id'      => $inbox->recipient_id,
                'group_id'          => $groups->id,
                'group_name'        => $groups->name,
                'recipient_name'    => $rcpnts->lastName . ' ' . $rcpnts->firstName,
                'updated_at' 		=> date('F d, Y [ h:i A D ]', strtotime($inbox->updated_at)),
            );
        }
        return json_encode($json);
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
