<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsView extends Model {

    protected $fillable = array('sms_id', 'user_id');

    /**
     * @param
     */
    public function user(){
        return $this->belongsTo('App\User');
	}

}
