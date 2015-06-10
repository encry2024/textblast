<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Commands\SendSmsCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

class SmsActivity extends Model {

	use DispatchesCommands;

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

	/**
	 * @param 
	 */
	public function team() {
		return $this->belongsTo('App\Team', 'recipient_team_id');
	}

	/**
	 * @param
	 */
	public function resend(){
		// update smsactivity status to PENDING
		$this->status = 'PENDING';
		$this->save();

		// Send to queue
		$this->dispatch(new SendSmsCommand($this->recipient_number->phone_number, $this->sms->message, $this->id));

		return true;
	}
}
