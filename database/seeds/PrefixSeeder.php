<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefixSeeder extends Seeder {

    public function run()
    {
        DB::table('mobile_prefix')->insert(
            array(
                array('prefix' => '813', 'network_name' => 'SMART'),
                array('prefix' => '817', 'network_name' => 'GLOBE'),
                array('prefix' => '905', 'network_name' => 'GLOBE'),
                array('prefix' => '906', 'network_name' => 'GLOBE'),
                array('prefix' => '907', 'network_name' => 'SMART'),
                array('prefix' => '908', 'network_name' => 'SMART'),
                array('prefix' => '909', 'network_name' => 'SMART'),
                array('prefix' => '910', 'network_name' => 'SMART'),
                array('prefix' => '912', 'network_name' => 'SMART'),
                array('prefix' => '915', 'network_name' => 'GLOBE'),
                array('prefix' => '916', 'network_name' => 'GLOBE'),
                array('prefix' => '917', 'network_name' => 'GLOBE'),
                array('prefix' => '918', 'network_name' => 'SMART'),
                array('prefix' => '919', 'network_name' => 'SMART'),
                array('prefix' => '920', 'network_name' => 'SMART'),
                array('prefix' => '921', 'network_name' => 'SMART'),
                array('prefix' => '922', 'network_name' => 'SUN'),
                array('prefix' => '923', 'network_name' => 'SUN'),
                array('prefix' => '925', 'network_name' => 'SUN'),
                array('prefix' => '926', 'network_name' => 'GLOBE'),
                array('prefix' => '927', 'network_name' => 'GLOBE'),
                array('prefix' => '928', 'network_name' => 'SMART'),
                array('prefix' => '929', 'network_name' => 'SMART'),
                array('prefix' => '930', 'network_name' => 'SMART'),
                array('prefix' => '932', 'network_name' => 'SUN'),
                array('prefix' => '933', 'network_name' => 'SUN'),
                array('prefix' => '934', 'network_name' => 'SUN'),
                array('prefix' => '935', 'network_name' => 'GLOBE'),
                array('prefix' => '936', 'network_name' => 'GLOBE'),
                array('prefix' => '937', 'network_name' => 'GLOBE'),
                array('prefix' => '938', 'network_name' => 'SMART'),
                array('prefix' => '939', 'network_name' => 'SMART'),
                array('prefix' => '942', 'network_name' => 'SUN'),
                array('prefix' => '943', 'network_name' => 'SUN'),
                array('prefix' => '946', 'network_name' => 'SMART'),
                array('prefix' => '947', 'network_name' => 'SMART'),
                array('prefix' => '948', 'network_name' => 'SMART'),
                array('prefix' => '949', 'network_name' => 'SMART'),
                array('prefix' => '977', 'network_name' => 'GLOBE'),
                array('prefix' => '989', 'network_name' => 'SMART'),
                array('prefix' => '994', 'network_name' => 'GLOBE'),
                array('prefix' => '996', 'network_name' => 'GLOBE'),
                array('prefix' => '997', 'network_name' => 'GLOBE'),
                array('prefix' => '998', 'network_name' => 'SMART'),
                array('prefix' => '999', 'network_name' => 'SMART'),
            )
        );
    }

}