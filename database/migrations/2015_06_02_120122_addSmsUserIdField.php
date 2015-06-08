<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsUserIdField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sms', function($table){
			$table->integer('user_id')->after('type');
		});

		Schema::table('sms_activities', function($table){
			$table->integer('user_id')->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sms', function($table){
			$table->dropColumn('user_id');
		});

		Schema::table('sms_activities', function($table){
			$table->dropColumn('user_id');
		});
	}

}
