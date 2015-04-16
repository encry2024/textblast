<?php

use Illuminate\Database\Seeder;

class UsernameSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->insert(
            array(
                array(
                    'email'      => 'jake@outsource2northstar.com',
                    'firstName'  => 'Christan Jake',
                    'lastName'   => 'Gatchalian',
                    'type'       => 'Admin',
                    'password'   => Hash::make('123'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ),
            )
        );
    }

}