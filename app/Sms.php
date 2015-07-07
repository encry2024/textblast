<?php namespace App;

use App\Commands\SendSmsCommand;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class Sms extends Eloquent {
	use DispatchesCommands, RecordsActivity;
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
		return $this->hasMany('App\SmsActivity')->orderBy('recipient_team_id');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function views(){
		return $this->hasMany('App\SmsView');
	}

	public function send($request) {
		// update and assign values
		$receivers= is_null($request->get('receivers'))?array():$request->get('receivers');
		$message = $request->get('message');
		$file = Input::file('smsNumbersFile');

		$this->message = $message;
		$this->type = 'SEND';
		$this->user_id = Auth::user()->id;
		$this->save();

		if(file_exists($file) AND count(file($file)) > 0) {
			$receivers = array_merge(file($file), $receivers);
		}

		# loop on all sender to check if existing recipients table or teams table, if not then create new
		if (count($receivers) > 0) {
			foreach($receivers as $receiver) {
				// get id and type
				$info = explode('-', $receiver);
				$id = $info[0];
				$type = isset($info[1])?$info[1]:'R';

				switch ($type) {
					case 'R':
						if (preg_match('/(\+63|0)9+[0-9]{9}/', $id, $matched)) {
							$mobileNumber = trim($matched[0]);
							$recipientNumber = RecipientNumber::where('phone_number', $mobileNumber)->first();

							if (count($recipientNumber) == 0) {
								$recipient = new Recipient();
								$recipient->name = "NO NAME";
								$recipient->save();


								$audit = new Audit();
								$audit->user_id = Auth::user()->id;
								$audit->action = "create new recipient";
								$audit->object = $recipient->name;
								$audit->save();
								

								// Recipient's who received this text is stored in a text file.
								$recipientNumber = $recipient->phoneNumbers()
									->save(new RecipientNumber([
										'recipient_id' => $recipient->id,
										'phone_number' => $mobileNumber
									]));

								$audit = new Audit();
								$audit->user_id = Auth::user()->id;
								$audit->action = "sent message to";
								$audit->object = $recipient->name;
								$audit->save();
							}
							$this->createActivityAndDispatch($recipientNumber, NULL, $message);
						} elseif($recipientNumber = RecipientNumber::find($id)) {
							$this->createActivityAndDispatch($recipientNumber, NULL, $message);
						}
						break;
					case 'T':
						if ($team = Team::find($id)) {
							$recipients = $team->recipients;

							$audit = new Audit();
							$audit->user_id = Auth::user()->id;
							$audit->action = "sent message to";
							$audit->object = $team->name;
							$audit->save();

							foreach ($recipients as $recipient) {
								if (count($recipientNumbers = $recipient->phoneNumbers) > 0) {
									foreach ($recipientNumbers as $recipientNumber) {
										$this->createActivityAndDispatch($recipientNumber, $team, $message);
									}
								}
							}
						}
						break;
					default:
						break;
				};
			}
		}
		return redirect()->back()->with('success_msg', 'Message has been sent to queue.');
	}

	public static function retrieve_Sms(){
		$json = array();
		$sms = Sms::where('type', '!=', 'SEND')->get();
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

	/**
	 * @param
	 */
	public function createActivityAndDispatch(RecipientNumber $recipientNumber, $team, $message){
		// Create SMSActivity object
		$smsActivity = $this->sms_activity()->save(new SmsActivity(['recipient_number_id' => $recipientNumber->id, 'recipient_team_id' => isset($team)?$team->id:0, 'status' => 'PENDING']));
		$smsActivity->user_id = Auth::user()->id;
		$smsActivity->save();
		// Send to queue
		$this->dispatch(new SendSmsCommand($recipientNumber->phone_number, $message, $smsActivity->id));
	}


	/**
	 * @param
	 */
	public function seen(){
		// only applicable to RECEIVED sms
		if($this->type != 'RECEIVED') return;

		// get the recipient id and insert smsView record for all activity for that recipient
		$smsActivity = SmsActivity::where('sms_id', $this->id)->where('status', 'RECEIVED')->first();
		$smsReceived = $smsActivity->recipient_number->smsReceived;
		foreach($smsReceived as $sms) {
			if($sms->seen == 1) continue;

			$sms->seen = 1;
			$sms->save();

			$sms->views()->save(new SmsView(['sms_id'=>$sms->id, 'user_id'=>Auth::user()->id]));
		}
	}

	/**
	 * @param
	 */
	public function reply($recipientNumber, $message){
		$this->message = $message;
		$this->type = 'SEND';
		$this->user_id = Auth::user()->id;
		$this->save();

		$this->createActivityAndDispatch($recipientNumber, NULL, $message);

		return redirect()->back()->with('success_msg', 'Message has been sent to queue.');
	}


	/**
	 * @param 
	 */
	public static function getCountUnreadSms(){
		return Sms::whereSeen('0')->whereType('RECEIVED')->count();
	}
}
