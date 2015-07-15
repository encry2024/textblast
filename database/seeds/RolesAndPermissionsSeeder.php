<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent;
use App\Role;
use App\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder {

    public function run()
    {
        // create roles
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'performs administrative tasks',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'Portal User',
            'description' => 'performs all basic tasks like sending SMS and managing contacts',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        // create permissions
        $editUser = Permission::create([
            'name' => 'edit-user',
            'display_name' => 'Edit Users',
            'description' => 'manage users',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $editContact = Permission::create([
            'name' => 'edit-contact',
            'display_name' => 'Edit Contacts',
            'description' => 'manage contacts',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $sendSms = Permission::create([
            'name' => 'send-sms',
            'display_name' => 'Send SMS',
            'description' => 'send and resend sms',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        // assign permissions to roles
        $admin->attachPermissions(array($editUser, $editContact, $sendSms));
        $user->attachPermissions(array($editContact, $sendSms));

        // attach admin user to admin role
        $userAdmin = User::where('email', env('ADMIN_EMAIL'))->firstOrFail();
        $userAdmin->attachRole($admin);

        // assign default role to users
        $users = User::all();
        foreach($users as $normalUser) {
            if($normalUser->hasRole('user')) continue;

            $normalUser->attachRole($user);
        }
    }

}