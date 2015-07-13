<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Auth;

class RecipientTeam extends Eloquent {

	//
	protected $table = 'recipient_teams';
	protected $fillable = ['team_id', 'recipient_id'];

	public function team() {
		return $this->belongsTo('App\Team');
	}

	public static function tagRecipient( $data ) {
		$receivers = $data->get('receivers');
		$description = $data->get('description');
		$team_id = $data->get('team_id');

		$group = Team::find($team_id);
/*		$group->description = $description;
		$group->save();*/

		if (count($receivers) > 0) {
			foreach ($receivers as $receiver) {
				$recipient = Recipient::where('name', $receiver)->first();

				if (count($recipient) > 0) {
					RecipientTeam::create(['team_id'=>$group->id, 'recipient_id'=>$recipient->id]);
				}
			}
		}
		return redirect()->back()->with('success_msg', 'Recipient was successfully added to the group');
	}
}
