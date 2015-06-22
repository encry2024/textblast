<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsernameSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->insert(
            array(
                array(
                    'email'      => env('ADMIN_EMAIL'),
                    'name'       => env('ADMIN_NAME'),
                    'type'       => env('ADMIN_TYPE'),
                    'password'   => Hash::make(env('ADMIN_PASSWORD')),
                    'status'     => env('ADMIN_STATUS'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ),
            )
        );
    }

}