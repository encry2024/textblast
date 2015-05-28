<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Recipient;
use Illuminate\Support\Facades\Input;
use App\Team;

class UpdateTeamRequest extends Request {

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
		$rules = [];

		if(count($this->request->get('receivers')) > 0) {
			foreach($this->request->get('receivers') as $key => $val)
			{
				$rules['receivers.'.$key] = 'unique:recipient_teams,recipient_id,NULL,id,team_id,'.$this->request->get('team_id');
			}
		}

		return $rules;
	}


	public function messages()
	{
		$messages = [];

		if(count($this->request->get('receivers')) > 0) {
			foreach ($this->request->get('receivers') as $key => $val) {
				$recipient = Recipient::find($val);
				$messages['receivers.' . $key . '.unique'] = $recipient->name . ' is already added in the group';
			}
		}

		return $messages;
	}

}
