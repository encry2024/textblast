<?php namespace App\Http\Controllers;

use App\Http\Requests;
// Models
use App\Sms;
use App\Http\Requests\CreateSmsRequest;


class SmsController extends Controller {


	/**
	 * @param Sms $sms
	 */
	public function __construct( Sms $sms ) {
		$this->sms = $sms;
	}

	/**
	 * @return json
	 */
	public function index() {
		$getSms = Sms::retrieve_Sms();

		return $getSms;
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
	 * @param CreateSmsRequest $request
	 * @return string
	 */
	public function store(CreateSmsRequest $request)  {
		$send_sms = Sms::send($request);

		return $send_sms;
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
	public function edit($id) {
		//
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
		$sent_sms = Sms::where('type','sent')->get();
		$failed_sms = Sms::where('type','failed')->get();
		$messages = Sms::where('type','received')->get();

		return view('sms.show', compact('sent_sms','failed_sms','messages'));
	}

	public function retrieveSms (){
		$ret = Sms::retrieving();

		return $ret;
	}

	public function retrieveRecipient (){
		$ret = \App\Sms::retrieve_recipients();

		return $ret;
	}

}