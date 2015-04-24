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
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RecipientNumber $rcp_num) {
		$update = $rcp_num->find( Input::get('rcp_id') );
		$update->phone_number = Input::get('phone_number');
		$update->provider = Input::get('provider');
		$update->save();

		return redirect()->back()->with('success_msg', "Recipient's contact was successfully updated.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$del_contact = App\RecipientNumber::find( Input::get('num_id') );
		$del_contact->delete();

		return redirect()->back()->with('success_msg', "Recipient's contact was successfully deleted.");
	}

}
