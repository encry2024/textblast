<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnRecipientNumberIdInSmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('sms', function($table)  {
			$table->dropColumn('recipient_number_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
