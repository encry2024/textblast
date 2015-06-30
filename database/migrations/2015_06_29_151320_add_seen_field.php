<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeenField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sms', function($table){
			$table->integer('seen')->after('user_id');
		});

		// query all sms_views and update seen status
		$smsViews = \App\SmsView::all();
		foreach($smsViews as $smsView) {
			\App\Sms::where('id', $smsView->sms_id)->update(['seen'=>1]);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sms', function($table){
			$table->dropColumn(array('seen'));
		});
	}

}
