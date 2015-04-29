<?php namespace App;

use App\Http\Requests;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;


class Recipient extends Eloquent {

	//
    use SoftDeletes;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

    public function phoneNumbers() {
        return $this->hasMany('App\RecipientNumber');
    }

    public function recipientTeam() {
        return $this->hasManyThrough('App\Team', 'App\RecipientTeam', 'recipient_id', 'id');
    }

    public static function register_Recipient($rcp_request, $rcp_n_request) {
        $store_recipient        = new Recipient();
        $store_recipient->name  = $rcp_request->get('name');
        $store_recipient->save();

        $recipient_id   =   $store_recipient->id;

        $store_recipient_number                 = new RecipientNumber();
        $store_recipient_number->recipient_id   = $recipient_id;
        $store_recipient_number->phone_number   = $rcp_n_request->get('phone_number');
        $store_recipient_number->provider       = $rcp_n_request->get('provider');

        $store_recipient_number->save();

        return redirect()->back()->with('success_msg', 'Recipient:'.$store_recipient->name.' was successfully saved.');
    }
}
