<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Sms extends Eloquent {

	//
	protected $fillable = array('recipient_id', 'message', 'type', 'team_id');

	public function recipient_number() {
		return $this->belongsTo('\App\RecipientNumber');
	}

	public function recipient_team() {
		return $this->belongsTo('RecipientTeam');
	}

	public function recipient(){
		return $this->hasOne('Recipient');
	}

	public static function send($request) {
		$receivers = $request->get('receivers');
		$sms = $request->get('message');

		# check if recipients is empty
		if (count($receivers) == 0) {
			return "No sender";
		}

		# loop on all sender to check if existing recipients table or teams table, if not then create new
		$sms_activity = new SmsActivity();
		foreach($receivers as $receiver) {
			if (preg_match('/(\+63|0)9+[0-9]{9}/', $receiver, $matched)) {
				$recipient_number = RecipientNumber::where('phone_number', $matched[0])->first();
				if(count($recipient_number) == 0) {
					$recipient = new Recipient();
					$recipient->name = "no name";
					$recipient->save();

					$recipient_number = $recipient->phoneNumbers()
						->save(new RecipientNumber([
							'recipient_id' => $recipient->id,
							'phone_number' => $receiver
						]));
				}

				$new_sms = new Sms();
				$new_sms->message = $sms;
				$new_sms->type = 'sent';
				$new_sms->save();

				# Save the activity to sms_activity
				$sms_activity->sms_id = $new_sms->id;
				$sms_activity->recipient_number_id = $recipient_number->id;
				$sms_activity->status = 'SENT';
				$sms_activity->save();

				# invoke send sms to GoipCommunicator
				$goipCommunicator = new GoipCommunicator(3);
				$goipCommunicator->sendSMSRequest($new_sms);

			}
			$team = Team::where('name', $receiver)->first();
			if (count($team) > 0 ) {
				$recipientNumbers = $team->recipient_numbers;
				//var_dump($recipientNumbers);
				foreach($recipientNumbers as $recipientNumber) {
					//var_dump($recipientNumber);
					$new_sms = new Sms();
					$new_sms->message = $sms;
					$new_sms->type = 'SEND';
					$new_sms->save();

					# Save action taken to Sms_activity
					$sms_activity->team_id = $team->id;
					$sms_activity->status = 'SENT';
					$sms_activity->save();

					// invoke send sms to GoipCommunicator
					$goipCommunicator = new GoipCommunicator(3);
					$goipCommunicator->sendSMSRequest($new_sms);
				}
			}
		}
		//return redirect()->back()->with('success_msg', 'Message has been sent');
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

	public static function retrieve_Sent() {
		$json = array();
		$sent_sms = Sms::where('type', 'SENT')->get();

		return $sent_sms;

		foreach ($sent_sms as $s_m) {
			$json[] = [
				'id' => $s_m->id,
				'msg' => $s_m->message,
				'date_sent'	=> $s_m->created_at,
			];
		}

		return json_encode($json);

	}
}
