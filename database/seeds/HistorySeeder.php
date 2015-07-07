<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistorySeeder extends Seeder {

	public function run()
	{
		for ($x = 0 ; $x < 2500 ; $x++) {
			DB::table('activities')->insert(
				array(
					array(
						'subject_id' => 22,
						'subject_type' => 'App\RecipientNumber',
						'name' => 'created_recipientnumber',
						'old_value' => NULL,
						'new_value' => NULL,
						'user_id' => 2,
						'created_at' => "2015-07-02 21:26:59",
						'updated_at' => "2015-07-02 21:26:59"
					),
				)
			);
		}
	}

}