<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\RecipientNumber;
use App\Sms;
use App\Http\Requests\SendSmsRequest;
use App\SmsActivity;
use App\Template;
use App\Http\Requests\CreateSmsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SmsController extends Controller {


	/**
	 * @param Sms $sms
	 */
	public function __construct( Sms $sms ) {
		// Add auth filter
		$this->middleware('auth.status');

		$this->sms = $sms;
	}

	/**
	 * @param 
	 */
	public function index(){
		$json = array();
		$getSms = Sms::orderBy('created_at', 'DESC')->get();

		foreach ($getSms as $sms) {
			//generate user views
			$users = [];
			foreach($sms->views as $view) {
				$users[] = $view->user->name;
			}

			$json[] = [
				'id' => $sms->id,
				'msg' => $sms->message,
				'sender' => isset($sms->user->name)?$sms->user->name:'',
				'type' => $sms->type,
				'recipients' => count($sms->sms_activity),
				'created_at' => date('m/d/Y h:i A', strtotime($sms->created_at)),
				'views' => json_encode($users)
			];
		}

		return json_encode($json);
	}

	/**
	 * @return
	 */
	public function inbox() {
		return view('sms.inbox');
	}

	/**
	 * @return
	 */
	public function outbox() {
		return view('sms.outbox');
	}

	/**
	 * @return
	 */
	public function sent() {
		return view('sms.sent');
	}

	/**
	 * @return
	 */
	public function failed() {
		return view('sms.failed');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Sms $sms) {
		return view('sms.edit', compact('sms'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function received(Sms $sms) {

		// insert sms views if applicable
		$sms->seen();

		return view('sms.received', compact('sms'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

	public function retSmsCount() {
		$templates = Template::all();
		return view('sms.show', compact('templates'));
	}

	public function retrieveSms (){
		$ret = Sms::retrieving();

		return $ret;
	}

	public function retrieveRecipient (){
		$ret = Sms::retrieve_recipients();

		return $ret;
	}

	public function getSent(){
		$get_sent = Sms::retrieve_Sent();

		return $get_sent;
	}

	/**
	 * @param
	 */
	public function send(SendSmsRequest $request){
		$sms = new Sms();
		$send_sms = $sms->send($request);

		return $send_sms;
	}

	/**
	 * @param
	 */
	public function reply(RecipientNumber $recipientNumber){
		$sms = new Sms();
		return $sms->reply($recipientNumber, Request::input('message'));
	}

	/**
	 * @param
	 */
	public function views(Sms $sms){
		$users = [];
		foreach($sms->views as $view) {
			$users[] = $view->user->name;
		}

		dd($users);
	}

	/**
	 * @param
	 */
	public function getSmsByStatusJSON($status){
		$json = array();
		$getSmsActivity = SmsActivity::whereStatus($status)->orderBy('created_at', 'DESC')->get();

		foreach ($getSmsActivity as $smsActivity) {
			$seenUsers = array();
			//generate user views
			$seenByUsers = $smsActivity->sms->views()->orderBy('sms_views.created_at')->lists('user_id');
			foreach($seenByUsers as $user) {
				array_push($seenUsers, \App\User::find($user)->name);
			}
			$users = implode(',', $seenUsers);

			$json[] = [
				'id' => $smsActivity->sms->id,
				'msg' => str_limit($smsActivity->sms->message, $limit=25, $end='...'),
				'full_msg' => $smsActivity->sms->message,
				'sender' => $smsActivity->status!='RECEIVED'?($smsActivity->user->name):($smsActivity->recipient_number->recipient->name . " (" . $smsActivity->recipient_number->phone_number . ")"),
				'recipient' => $smsActivity->status!='RECEIVED'?($smsActivity->recipient_number->recipient->name . " (" . $smsActivity->recipient_number->phone_number . ")"):($smsActivity->goip_name),
				'origin' => $smsActivity->goip_name,
				'created_at' => date('m/d/Y h:i A', strtotime($smsActivity->created_at)),
				'seen_by' => $users
			];
		}

		return json_encode($json);
	}

	/**
	 * @param
	 */
	public function prepareInbox(){
		$json = array();
		$getSmsActivity = DB::table('sms')
							->join('sms_activities', 'sms.id', '=', 'sms_activities.sms_id')
							->where('sms_activities.status', 'RECEIVED')
							->groupBy('sms_activities.recipient_number_id')
							->orderBy('sms.seen')
							->orderBy('sms_activities.created_at', 'DESC')
							->select(DB::raw('max(txt_sms_activities.sms_id) as sms_id, txt_sms_activities.recipient_number_id'))
							->get();
		//$getSmsActivity = SmsActivity::whereStatus('RECEIVED')->groupBy('recipient_number_id')->orderBy('created_at', 'DESC')->select(DB::raw('max(sms_id) as sms_id, recipient_number_id'))->get();

		foreach ($getSmsActivity as $smsActivity) {
			$sms = Sms::find($smsActivity->sms_id);
			$recipientNumber = RecipientNumber::find($smsActivity->recipient_number_id);

			$seenUsers = array();
			//generate user views
			$seenByUsers = $sms->views()->orderBy('sms_views.created_at')->lists('user_id');
			foreach($seenByUsers as $user) {
				array_push($seenUsers, \App\User::find($user)->name);
			}
			$users = implode(',', $seenUsers);

			$json[] = [
				'id' => $sms->id,
				'msg' => $sms->seen==1?str_limit($sms->message, $limit=30, $end='...'):"<strong style='font-size: 16px'>" .str_limit($sms->message, $limit=30, $end='...'). "</strong>",
				'full_msg' => $sms->message,
				'sender' => $recipientNumber->recipient->name . " (" . $recipientNumber->phone_number . ")",
				'created_at' => date('m/d/Y h:i A', strtotime($sms->created_at)),
				'seen_by' => $users
			];
		}

		return json_encode($json);
	}
}