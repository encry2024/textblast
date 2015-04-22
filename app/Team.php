<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Eloquent {

	use SoftDeletes;

	protected $softDelete = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['name', 'description'];
	//
	public function recipientTeam() {
		return $this->hasMany('App\RecipientTeam');
	}
}
