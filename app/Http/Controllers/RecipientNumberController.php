<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateRecipientNumberRequest;
use App\RecipientNumber;

class RecipientNumberController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function ___construct(RecipientNumber $recipientNumber){
		$this->recipientNumber = $recipientNumber;
	}


	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * @param CreateRecipientNumberRequest $rcp_n_request
	 * @return mixed
	 */
	public function store(CreateRecipientNumberRequest $rcp_n_request) {
		$store_recipient = RecipientNumber::register_RecipientNumber($rcp_n_request->all(), Input::get('rcpt_id'));

		return $store_recipient;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * @param RecipientNumber $rcp_num
	 * @return Response
	 */
	public function update(RecipientNumber $rcp_num) {
		$update = RecipientNumber::update_RecipientNumber( $rcp_num);

		return $update;
	}

	/**
	 * Remove the specified resource from storage.
	 * RecipientNumber
	 * @param RecipientNumber $recipientNumber
	 * @return Response
	 */
	public function destroy(RecipientNumber $recipientNumber) {
		$del_contact = $recipientNumber->find( Input::get('num_id') );
		$del_contact->delete();

		return redirect()->back()->with('success_msg', "Recipient's contact was successfully deleted.");
	}

	public function getNumber(){
		$return_nums = RecipientNumber::getNumFnc();

		return $return_nums;
	}

}
