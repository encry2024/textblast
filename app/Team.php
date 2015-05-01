<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Eloquent {

	use SoftDeletes;

	protected $table = 'teams';
	protected $softDelete = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'description'];
	//
	public function recipient_team() {
		return $this->hasMany('App\RecipientTeam');
	}

	public function recipients(){
		return $this->belongsToMany('App\Recipient', 'recipient_teams');
	}

	/**
	 *
	 */
	public function recipient_numbers()
	{
		return $this->hasManyThrough('App\RecipientNumber', 'App\RecipientTeam', 'team_id', 'recipient_id');
	}
}
