<?php namespace App\Http\Controllers;

use App\Http\Requests;

# MODELS
use App\RecipientNumber;
use App\Recipient;
use App\Team;
use App\RecipientTeam;

use App\Http\Requests\CreateRecipientNumberRequest;
use App\Http\Requests\CreateRecipientRequest;


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

            foreach ($recipientNumbers as $r_n ) {
                $json[] = array(
                    'id' 				=> $recipient->id,
                    'name' 				=> $recipient->name,
                    'provider'          => $r_n->provider,
                    'recipient_number'  => $r_n->phone_number,
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
	public function store(CreateRecipientRequest $rcp_request,
                          CreateRecipientNumberRequest $rcp_n_request) {

        $store_recipient = Recipient::register_Recipient($rcp_request, $rcp_n_request);

        return $store_recipient;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Recipient $recipient)
	{
		$rpt_nums = RecipientNumber::where('recipient_id', $recipient->id)->get();
		return view('contacts.edit', compact('recipient', 'rpt_nums'));
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
