<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Support\Facades\Input;

class RecipientNumber extends Eloquent {

	//
	protected $fillable = array('phone_number');


	public function recipient() {
		return $this->belongsTo('App\Recipient');
	}


	public static function register_RecipientNumber( $get_num_req, $id ){
		$reg_rec_num = new RecipientNumber();
		$reg_rec_num->phone_number 	= $get_num_req["phone_number"];
		$reg_rec_num->provider		= $get_num_req["provider"];
		$reg_rec_num->recipient_id	= $id;
		$reg_rec_num->save();

		return redirect()->back()->with('success_msg', 'Additional Contact Number has been proccessed successfully');
	}

	public static function update_RecipientNumber($rcp_num){
		$phone = Input::get('phone_number');
		$provider = Input::get('provider');

		$rcp_num->find(Input::get('rcp_id'))->update(['phone_number' => $phone, 'provider' => $provider]);
		Recipient::find(Input::get('rcp_id'))->touch();
		return redirect()->back()->with('success_msg', "Recipient's contact was successfully updated.");
	}
}
