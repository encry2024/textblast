<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_activities', function( Blueprint $table ) {
			$table->increments('id')->unsigned();
			$table->integer('sms_id')->unsigned();
			$table->integer('team_id')->unsigned();
			$table->integer('recipient_number_id')->unisgned();
			$table->string('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_activities');
	}

}
