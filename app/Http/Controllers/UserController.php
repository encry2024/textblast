<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Audit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Role;

class UserController extends Controller {

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
		$accounts = User::where('email', '!=', env('ADMIN_EMAIL'))->paginate(20);

		return view('user.users', compact('accounts'));
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
	public function show($user)
	{
		//
		return view('user.show', compact('user'));
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
	public function update($user, Request $request)
	{
		//
		$update_status = User::updateStatus($user, $request);
		return $update_status;
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

	public function viewChangePassword()
	{
		return view('auth.change_password');
	}

	# JSONS

	public function fetchUser()
	{
		# code...
		$fetch_user = User::fetch_users();

		return $fetch_user;
	}

	public function fetch_status($user_id) {
		# code...
		$fetchStatus = User::fetchStatus($user_id);

		return $fetchStatus;
	}

	public function changePass( Request $request )
	{
		User::find(Auth::user()->id)->update(['password' => Hash::make($request->get('password'))]);

		Auth::logout();

		return redirect('auth/login')->with('success_msg', 'Your password was successfully changed');
	}

	/**
	 * @param
	 */
	public function updatePermissions(User $user, Request $request){
		//detach first all roles
		$user->detachRoles(Role::all());

		//insert new roles
		$role = $request->get('role');
		$user->attachRole(Role::whereName($role)->first());

		return Redirect::back();
	}
}
