<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipientNumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipient_numbers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('recipient_id')->unsigned();
            $table->string('phone_number', 14);
            $table->string('provider');
            $table->softDeletes();
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
		Schema::drop('recipient_numbers');
	}

}
