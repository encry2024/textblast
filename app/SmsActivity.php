<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Commands\SendSmsCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Facades\Auth;


class SmsActivity extends Model {

	use DispatchesCommands;

	protected $table = 'sms_activities';
	protected $fillable = ['sms_id', 'recipient_team_id', 'recipient_number_id', 'status', 'goip_name'];

	//
	public function sms() {
		return $this->belongsTo('App\Sms');
	}

	public function user() {
		return $this->belongsTo('App\User');
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

		$audit = new Audit();
		$audit->user_id = Auth::user()->id;
		$audit->action = "resend";
		$audit->object =  "message: " . $this->sms->message . " to " . $this->recipient_number->recipient->name;
		$audit->save();

		// Send to queue
		$this->dispatch(new SendSmsCommand($this->recipient_number->phone_number, $this->sms->message, $this->id));

		return true;
	}
}
