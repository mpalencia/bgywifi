<?php

use BrngyWiFi\Modules\Roles\Models\Roles as Roles;

class RolesTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	['description' => 'admin'],
        	['description' => 'security'],
        	['description' => 'home_owner'],
        ]);
    }
}
