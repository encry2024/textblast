<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

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
	public function rules()
	{
		return [
			'team_id' => 'required|unique:recipient_teams,recipient_id',
			'recipient_id'	=>	'required',
			//
		];
	}

	public function messages()
	{
		$recipientTeam_id = ($this->id) ?: 'NULL';
		return [
			'team_id.unique' => 'The recipient is already in that group ' . $recipientTeam_id
		];
	}

}
