<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;


class RecipientTeam extends Eloquent {

	//

	protected $fillable = ['team_id', 'recipient_id'];

	public function team(){
		return $this->belongsTo('App\Team');
	}
}
