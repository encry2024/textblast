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

		$message = $this->sms->message;

		$messages = explode( "\n", wordwrap($message, 150));

		$total = count($messages);
		$counter = 0;
		foreach($messages as $message) {
			// Send to queue
			++$counter;
			$smsCount = $total>1?"[{$counter}/{$total}] ":"";
			Queue::push(new SendSmsCommand($this->recipient_number->phone_number, "{$smsCount}{$message}", $this->id));
		}

		return true;
	}

	/**
	 * @param 
	 */
	public static function getCountPendingSms(){
		return SmsActivity::whereStatus('PENDING')->count();
	}

	/**
	 * @param
	 */
	public static function getCountFailedSms(){
		return SmsActivity::whereStatus('FAILED')->count();
	}

	public static function getCountSentSms(){
		return SmsActivity::whereStatus('SENT')->count();
	}
}
