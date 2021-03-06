<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class RecipientNumber extends Eloquent {

	//

	use RecordsActivity;

	protected $fillable = array('phone_number');


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function recipient() {
		return $this->belongsTo('App\Recipient');
	}

	public function getDeletedRecipients() {
		return $this->belongsTo('App\Recipient', 'id')->withTrashed();
	}

	/**
	 * @param
	 */
	public function smsActivities(){
		return $this->hasMany('App\SmsActivity')->orderBy('created_at');
	}

	/**
	 * @param
	 */
	public function smsReceived(){
		return $this->belongsToMany('App\Sms', 'sms_activities')->wherePivot('status', 'RECEIVED');
	}

	/**
	 * @param $get_num_req
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public static function register_RecipientNumber( $get_num_req, $id ){
		$reg_rec_num = new RecipientNumber();
		$reg_rec_num->phone_number 	= $get_num_req["phone_number"];
		$reg_rec_num->provider		= $get_num_req["provider"];
		$reg_rec_num->recipient_id	= $id;
		$reg_rec_num->save();

		return redirect()->back()->with('success_msg', 'Additional Contact Number has been proccessed successfully');
	}

	/**
	 * @param $rcp_num
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public static function update_RecipientNumber() {
		$phone	= Input::get('phone_number');
		$provider = Input::get('provider');

		$user = User::find(Auth::user()->id);

		$rcp_num = RecipientNumber::find(Input::get('rcp_id'));

		$user->recordActivity('updates', $rcp_num);
		/*$rcp_num->update(['phone_number' => $phone, 'provider' => $provider]);
		$recipient = $rcp_num->recipient;
		$recipient->touch();*/


		return redirect()->back()->with('success_msg', "Recipient's contact was successfully updated.");
	}

	/**
	 * @param $phone
	 * @return mixed
	 */
	public static function checkPhoneExist($phone) {
		//get the first 10 digits from the right of the phone
		$numbers = parent::whereRaw('right(phone_number, 10) = right("'.$phone.'", 10) limit 1')->get();

		foreach($numbers as $number) return $number;
	}

	public static function getNumFnc(){
		$json = array();
		$getNum = \App\RecipientNumber::all();

		foreach ($getNum as $contact) {
			$json[] = [
				'number' => $contact->phone_number,
				'id'	 => $contact->id
			];
		}

		return json_encode($json);
	}
}
