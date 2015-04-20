<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\RecipientNumber;
use App\Recipient;
use App\Team;
use App\RecipientTeam;

class RecipientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * return Response
	 */
    public function __construct(Recipient $recipient, RecipientNumber $recipient_number,
                                RecipientTeam $recipient_team, Team $team) {
        $this->recipient = $recipient;
        $this->recipient_number = $recipient_number;
        $this->recipient_team = $recipient_team;
        $this->team = $team;
    }

	public function index()
	{
		//code...
        $json = array();
        $recipients = $this->recipient->get();
        foreach ($recipients as $recipient) {

            $recipientNumbers = $this->recipient_number->where('recipient_id', $recipient->id)->get();
            $recipientTeam_id = $this->recipient_team->where('recipient_id', $recipient->id)->get();
            $team_info = $this->team->find($recipientTeam_id->team_id);

            foreach ($recipientNumbers as $r_n ) {
                $json[] = array(
                    'id' 				=> $recipient->id,
                    'name' 				=> $recipient->name,
                    'provider'          => $recipient->provider,
                    'group_name'        => $team_info->name,
                    'group_id'          => $team_info->id,
                    'recipient_phone'   => $r_n->phonenumber,
                    'recent_updates'    => date('F d, Y [ h:i A D ]', strtotime($recipient->updated_at)),
                );
            }
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
