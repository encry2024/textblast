<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class InboxController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(Inbox $inbox) {
        $this->inbox = $inbox;
    }

	public function index()
	{
		//code...
        $json = array();
        $inboxes = $this->inbox->get();
        foreach ($inboxes as $inbox) {

            $json[] = array(
                'id' 				=> $recipient->id,
                'slug'              => $recipient->id,
                'name' 				=> $recipient->name,
                'updated_at' 		=> date('F d, Y [ h:i A D ]', strtotime($category->updated_at)),
            );
        }
        return json_encode($json);
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

}
