<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\RecipientNumber;
use App\Recipient;
use App\Sms;

class CreateRecipientNumberRequest extends Request {

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
			'phone_number' => 'required|unique:recipient_numbers,phone_number',
            'provider'     => 'required',
		];
	}

	/**
	 *
	 * @return array
	 */
	public function messages()
	{

		$recipient_pn = ($this->phone_number) ?: 'NULL';
		$rcpt_id = RecipientNumber::where('phone_number', $recipient_pn)->first();
		if ( $rcpt_id != NULL) {
			$recipient = Recipient::find($rcpt_id->recipient_id);

			return [
				'phone_number.unique' => "Phone Number is already taken by: " .  $recipient->name,
				'provider.required'	=> "You need to provide the Carrier/Provider",
			];
		} else {
			return [
				'phone_number.unique' => "Phone Number is already taken",
				'provider.required'	=> "You need to provide the Carrier/Provider",
			];
		}
	}
}
