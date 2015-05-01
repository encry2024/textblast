<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goips', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->string('ip_address', 50);
			$table->string('port', 10);
			$table->string('password', 60);
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
		Schema::drop('goips');
	}

}
