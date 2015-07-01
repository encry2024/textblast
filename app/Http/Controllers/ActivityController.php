<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct()
	{
		$this->middleware('auth.status');
	}

	public function index()
	{
		return view('admin.history');
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function fetchHistory()
	{
		$json = [];
		$activities = Activity::with(['user', 'subject'])->latest()->get();

		foreach ($activities as $event) {
			if ($event->name == "created_recipient") {
				$json[] = [
					'event_id' => $event->id,
					'user_name' => $event->user->name,
					'user_id' => $event->user->id,
					'event_name' => 'added new Recipient :: ' . $event->subject->name,
					'created_at' => date('m/d/Y h:i A', strtotime($event->created_at))
				];
			}

			if ($event->name == "created_recipient") {
				$json[] = [
					'event_id' => $event->id,
					'user_name' => $event->user->name,
					'user_id' => $event->user->id,
					'event_name' => 'added new Recipient :: ' . $event->subject->name,
					'created_at' => date('m/d/Y h:i A', strtotime($event->created_at))
				];
			}

		}

		return json_encode($json);
	}

}
