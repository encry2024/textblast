<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsActivity extends Model {

	protected $table = 'sms_activities';
	protected $fillable = ['sms_id', 'recipient_team_id', 'recipient_number_id', 'status'];

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
