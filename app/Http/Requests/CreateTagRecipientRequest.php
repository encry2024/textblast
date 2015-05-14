<?php namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use App\Recipient;

class CreateTagRecipientRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


	/**
	 * @return array
	 */
	public function rules() {
		$validations = array();

		$receivers = Input::get('receivers');
		$team_id = ($this->team_id) ?: 'NULL';
		//dd($team_id);
		if ( count($receivers) > 0 ) {
			foreach ($receivers as $key => $receiver) {
				$recipient = Recipient::where('name', $receiver)->first();
				$r_id = $recipient->id;

				/*  $validations['receivers[]'] = $receiver;
				 	$rules['receivers'.$key] =
					$validations['receivers[]'.$key] = []
					$validations[] = ['team_id'=>'unique:recipient_teams,team_id,NULL,id,recipient_id,'.$r_id];
					$fields = array('team_id' => $team_id); */

				$validations[] = array('team_id' => 'unique:recipient_teams,team_id,NULL,NULL,recipient_id,'.$r_id);
			}
		}
		dd([$validations]);
		//return $validations;
	}

	public function messages()
	{
		$messages = [];
		foreach($this->request->get('receivers') as $key => $val) {
			$messages['receivers'.'unique'] = 'The recipient is already in this Group';
		}
		return $messages;
		/*return [
			'team_id.unique' => 'The recipient is already in this Group'
		];*/
	}

}
