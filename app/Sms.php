<?php namespace App;

use App\Commands\SendSmsCommand;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Bus\DispatchesCommands;

class Sms extends Eloquent {
	use DispatchesCommands;
	//
	protected $fillable = array('recipient_id', 'message', 'type', 'team_id');

	public function recipient_number() {
		return $this->belongsTo('App\RecipientNumber');
	}

	public function recipient_team() {
		return $this->belongsTo('App\RecipientTeam');
	}

	public function recipient(){
		return $this->hasOne('App\Recipient');
	}

	public function sms_activity() {
		return $this->hasMany('App\SmsActivity');
	}

	public function send($request) {
		$receivers = $request->get('receivers');
		$message = $request->get('message');

		# check if recipients is empty
		if (count($receivers) == 0) {
			return "No sender";
		}

		# loop on all sender to check if existing recipients table or teams table, if not then create new
		$this->message = $message;
		$this->type = 'sent';
		$this->save();

		// phone_numbers array
		foreach($receivers as $receiver) {
			if (preg_match('/(\+63|0)9+[0-9]{9}/', $receiver, $matched)) {
				$recipient_number = RecipientNumber::where('phone_number', $matched[0])->first();
				if (count($recipient_number) == 0) {
					$recipient = new Recipient();
					$recipient->name = "no name";
					$recipient->save();

					$recipient_number = $recipient->phoneNumbers()
						->save(new RecipientNumber([
							'recipient_id' => $recipient->id,
							'phone_number' => $receiver
						]));
				}

				// Create SMSActivity object
				$smsActivity = new SmsActivity();
				$smsActivity->sms_id = $this->id;
				$smsActivity->recipient_number_id = $recipient_number->id;
				$smsActivity->recipient_team_id = 0;
				$smsActivity->status = 'PENDING';
				$smsActivity->save();

				// Send to queue
				$this->dispatch(new SendSmsCommand($recipient_number->phone_number, $message, $smsActivity->id));
			}

			$team = Team::where('name', $receiver)->first();
			if (count($team) > 0 ) {
				$recipients = $team->recipients;

				foreach($recipients as $recipient) {
					$recipient_number = RecipientNumber::where('recipient_id', $recipient->id)->first();

					// Create SMSActivity object
					$smsActivity = new SmsActivity();
					$smsActivity->sms_id = $this->id;
					$smsActivity->recipient_number_id = $recipient_number->id;
					$smsActivity->recipient_team_id = 0;
					$smsActivity->status = 'PENDING';
					$smsActivity->save();

					// Send to queue
					$this->dispatch(new SendSmsCommand($recipient_number->phone_number, $message, $smsActivity->id));
				}
			}
		}
		return redirect()->back()->with('success_msg', 'Message has been sent to queue.');
	}

	public static function retrieve_Sms(){
		$json = array();
		$sms = Sms::where('type', '!=', 'sent')->get();
		foreach ($sms as $msg) {
			$recipient = Recipient::where('id', $msg->related_id)->get();
			foreach ($recipient as $r) {
				$rp_num = RecipientNumber::where('recipient_id', $r->id)->get();
				foreach ($rp_num as $rnum) {
					$json[] = array(
						'id' => $msg->id,
						'name' => $r->name,
						'msg' => str_limit($msg->message, $limit = 15, $end = '...'),
						'msg_type' => $msg->related_type,
						'type' => $msg->type,
						'received' => date('F d, Y [ h:i A D ]', strtotime($msg->created_at)),
					);
				}
			}
		}
		return json_encode($json);
	}

	public static function retrieving() {
		$json = array();
			$recipient_number = RecipientNumber::all();

			$team = Team::all();
			foreach ($team as $t) {
				$json[] = [
					'id' => $t->id,
					'dta' => $t->name
				];
			}

		$recipient = Recipient::with('phoneNumbers')->get();

		foreach ($recipient as $r) {
			foreach ($r->phoneNumbers as $rpn) {
				$json[] = [
					'dta' 	=> $r->name . " <" . $rpn->phone_number.">",
					'id'	=> $r->id
				];
			}
		}

		return json_encode($json);
	}

	public static function retrieve_recipients() {
		$json = array();
		$recipient = Recipient::all();

		foreach ($recipient as $r) {
			$json[] = [
				'dta' 	=> $r->name,
				'id'	=> $r->id
			];
		}

		return json_encode($json);
	}
}
