<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function audit()
	{
		return $this->hasMany('App\Audit');
	}

	public static function fetch_users()
	{
		$json = [];
		$users = User::where('type', '!=', 'Admin')->get();

		foreach ($users as $user) {

			$json[] = [
				'user_id' => $user->id,
				'user_name' => $user->name,
				'user_type' => $user->type,
				'user_email' => $user->email,
				'user_status' => $user->status!=1 ? 'INACTIVE':'ACTIVE',
				'updated_at' => date('m/d/Y h:i A', strtotime($user->updated_at))
			];
		}

		return json_encode($json);
	}

	public static function updateStatus($user, $request) {
		$user = User::find($user->id)->update(['status' => $request->get('status')]);
	}

	public static function fetchStatus($user_id) {
		$user = User::find($user_id);
		$status = $user->status!=1 ? 'INACTIVE':'ACTIVE';
		return json_encode($status);
	}

}
