<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsView extends Model {

    /**
     * @param
     */
    public function user(){
        return $this->belongsTo('App\User');
	}

}
