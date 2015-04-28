<?php namespace App\Http\Controllers;

use App\Http\Requests;

# MODELS
use App\RecipientNumber;
use App\Recipient;
use App\Team;
use App\RecipientTeam;

# REQUESTS
use App\Http\Requests\CreateRecipientNumberRequest;
use App\Http\Requests\CreateRecipientRequest;


class RecipientController extends Controller {


	/**
	 * @param Recipient $recipient
	 * @param RecipientNumber $recipient_number
	 * @param RecipientTeam $recipient_team
	 * @param Team $team
	*/
	public function __construct(Recipient $recipient, RecipientNumber $recipient_number,
                                RecipientTeam $recipient_team, Team $team) {
        $this->recipient = $recipient;
        $this->recipient_number = $recipient_number;
        $this->recipient_team = $recipient_team;
        $this->team = $team;
    }

	/**
	 * @return string
	 */
	public function index()
	{
		//code...
        $json = array();
        $recipients = $this->recipient->get();
        foreach ($recipients as $recipient) {
			$json[] = array(
				'id' 				=> $recipient->id,
				'name' 				=> $recipient->name,
				'recent_updates'    => date('F d, Y [ h:i A D ]', strtotime($recipient->updated_at)),
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
	 * @param CreateRecipientRequest $rcp_request
	 * @param CreateRecipientNumberRequest $rcp_n_request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(CreateRecipientRequest $rcp_request,
                          CreateRecipientNumberRequest $rcp_n_request) {

        $store_recipient = Recipient::register_Recipient($rcp_request, $rcp_n_request);

        return $store_recipient;
	}


	/**
	 * @param Recipient $recipient
	 * @param Team $team
	 * @param RecipientTeam $recipientTeam
	 * @return \Illuminate\View\View
	 */
	public function show(Recipient $recipient, Team $team,
                         RecipientTeam $recipientTeam) {

		$rpt_nums = RecipientNumber::where('recipient_id', $recipient->id)->get();
        $recipientTeams = $recipientTeam->where('recipient_id', $recipient->id)->get();

		return view('contacts.edit', compact('recipient', 'rpt_nums', 'recipientTeams'));
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
	 * @param CreateRecipientRequest $crr
	 * @param  Recipient $recipient
	 * @return Response
	 */
	public function update( Recipient $recipient, CreateRecipientRequest $crr ) {
		$recipient->name = $crr->get('name');
		$recipient->save();

		return redirect()->back()->with('success_msg', "Recipient's name was successfully updated.");
	}

	/**
	 * Remove the specified resource from storage.
	 * @param Recipient $recipient
	 * @return Response
	 */
	public function destroy(Recipient $recipient)
	{
		//
		$recipient->delete();

		return redirect( route('pb') )->with('success_msg', 'Recipient was successfully deleted');
	}

	public function number() {
		
	}

}
