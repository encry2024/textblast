<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Sms;
use App\Http\Requests\SendSmsRequest;
use App\Template;
use App\Http\Requests\CreateSmsRequest;

class SmsController extends Controller {


	/**
	 * @param Sms $sms
	 */
	public function __construct( Sms $sms ) {
		// Add auth filter
		$this->middleware('auth');

		$this->sms = $sms;
	}

	/**
	 * @return json
	 */
	public function index() {
		$json = array();
		$getSms = Sms::orderBy('created_at', 'DESC')->get();

		foreach ($getSms as $sms) {
			$json[] = [
				'id' => $sms->id,
				'msg' => $sms->message,
				'sender' => isset($sms->user->name)?$sms->user->name:'',
				'type' => $sms->type,
				'recipients' => count($sms->sms_activity),
				'created_at' => date('m/d/Y h:i A', strtotime($sms->created_at))
			];
		}

		return json_encode($json);
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
	public function edit($sms) {
		//
		return view('sms.edit', compact('sms'));
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
		$get_sent = \App\Sms::retrieve_Sent();

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

}