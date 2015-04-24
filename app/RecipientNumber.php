<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;


class RecipientNumber extends Eloquent {

	//

	public function recipient() {
		return $this->belongsTo('Recipient');
	}

	public static function register_RecipientNumber( $get_num_req, $id ){
		$reg_rec_num = new RecipientNumber();
		$reg_rec_num->phone_number 	= $get_num_req["phone_number"];
		$reg_rec_num->provider		= $get_num_req["provider"];
		$reg_rec_num->recipient_id	= $id;
		$reg_rec_num->save();

		return redirect()->back()->with('success_msg', 'Additional Contact Number has been proccessed successfully');
	}
}
