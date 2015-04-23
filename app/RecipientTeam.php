<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class RecipientTeam extends Eloquent {

	//
	use SoftDeletes;

	protected $softDelete = true;
	protected $dates = ['deleted_at'];
	protected $fillable = ['team_id', 'recipient_id'];

	public function team(){
		return $this->belongsTo('App\Team');
	}
}
