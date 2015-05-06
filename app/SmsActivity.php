<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsActivity extends Model {

	//
	public function sms() {
		return $this->hasOne('Sms');
	}

}
