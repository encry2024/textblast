<?php namespace App;

use App\Http\Requests;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;



class Recipient extends Eloquent {

	//
    use SoftDeletes, RecordsActivity;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

    public function phoneNumbers() {
        return $this->hasMany('App\RecipientNumber')->select(array('phone_number'));;
    }

    public function numbers() {
        return $this->hasMany('App\RecipientNumber');
    }

    public function recipientTeam() {
        return $this->hasManyThrough('App\Team', 'App\RecipientTeam', 'recipient_id', 'id');
    }

	public function teams() {
		return $this->belongsToMany('App\Team', 'recipient_teams');
	}

    public static function register_Recipient($rcp_request, $rcp_n_request) {

        $user = User::find(Auth::user()->id);

        $store_recipient        = new Recipient();
        $store_recipient->name  = $rcp_request->get('name');
        if ($store_recipient->save()) {
            $user->recordActivity('added new', $store_recipient);
        }

        $recipient_id   =   $store_recipient->id;

        $store_recipient_number                 = new RecipientNumber();
        $store_recipient_number->recipient_id   = $recipient_id;
        $store_recipient_number->phone_number   = $rcp_n_request->get('phone_number');
        $store_recipient_number->provider       = $rcp_n_request->get('provider');

        $store_recipient_number->save();

        return redirect()->back()->with('success_msg', 'Recipient:'.$store_recipient->name.' was successfully saved.');
    }
}
