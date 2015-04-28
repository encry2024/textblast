<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RecipientTeam extends Eloquent {

	//
	protected $table = 'recipient_teams';
	protected $fillable = ['team_id', 'recipient_id'];

	public function team(){
		return $this->belongsTo('App\Team');
	}
}
