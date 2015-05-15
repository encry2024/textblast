<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsActivity extends Model {

	//
	public function sms() {
		return $this->belongsTo('App\Sms');
	}

	public function recipientTeam() {
		return $this->belongsTo('App\RecipientTeam');
	}

	public function recipient_number() {
		return $this->belongsTo('App\RecipientNumber');
	}
}
