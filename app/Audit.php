<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Audit extends Eloquent {

	//
	protected $table = 'audits';

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function checkStatus() {
		return $this->status;
	}
}
