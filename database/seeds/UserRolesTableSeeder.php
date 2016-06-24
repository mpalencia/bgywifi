<?php

class UserRolesTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            ['user_id' => 1, 'role_id' => 2],
            ['user_id' => 2, 'role_id' => 3],
            ['user_id' => 3, 'role_id' => 1],

        ]);
    }
}
