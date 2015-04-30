<?php

use Illuminate\Database\Seeder;

class GoipSeeder extends Seeder
{

    public function run()
    {
        $goips = array();

        //generate 8 goips entries

        for ($i = 1; $i <= 8; $i++) {
            $goips[] = array(
                'name' => 'goip' . $i,
                'ip_address' => '191.168.3.76',
                'port' => '999' . $i,
                'password' => '1234goip',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
        }


        DB::table('goips')->insert($goips);
    }

}