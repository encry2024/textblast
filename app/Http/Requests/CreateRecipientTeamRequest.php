<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Team;

class CreateRecipientTeamRequest extends Request {

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
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$recipientTeam_id = ($this->recipient_id) ?: 'NULL';
		return [
			'team_id' => 'unique:recipient_teams,team_id,,,recipient_id,'.$recipientTeam_id
			//
		];
	}

	public function messages()
	{
		$recipientTeam_id = ($this->team_id) ?: 'NULL';
		$tm = Team::find($recipientTeam_id);
		return [
			'team_id.unique' => 'The recipient is already in the Group:' . $tm->name
		];
	}

}
