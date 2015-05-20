<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NetworkSeeder extends Seeder {

    public function run()
    {
        DB::table('networks')->insert(
            array(
                array(
                    'name'      => 'GLOBE'
                ),
                array(
                    'name'      => 'SMART'
                ),
                array(
                    'name'      => 'SUN'
                ),
            )
        );
    }

}