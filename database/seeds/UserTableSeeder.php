<?php

class UserTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'first_name' => 'Gabriel',
            'last_name' => 'Raymundo',
            'username' => 'security',
            'password' => bcrypt('security'),
            'email' => 'gab@gmail.com',
            'pin_code' => null,
            'contact_no' => '639266840144',
            'remember_token' => str_random(10),
            'main_account_id' => 1,
        ], [
            'first_name' => 'Kevin',
            'last_name' => 'Villanueva',
            'username' => 'homeowner',
            'password' => bcrypt('homeowner'),
            'email' => 'raymundo.gabriel7@gmail.com',
            'pin_code' => null,
            'contact_no' => null,
            'remember_token' => str_random(10),
            'main_account_id' => 2,
        ], /*[
        'first_name' => 'Ichigo',
        'last_name' => 'Kurosaki',
        'username' => 'homeowner2',
        'password' => bcrypt('homeowner2'),
        'email' => 'ichigo@gmail.com',
        'pin_code' => null,
        'contact_no' => null,
        'remember_token' => str_random(10),
        ], [
        'first_name' => 'Aizen',
        'last_name' => 'Sama',
        'username' => 'homeowner3',
        'password' => bcrypt('homeowner3'),
        'email' => 'aizen@gmail.com',
        'pin_code' => null,
        'contact_no' => null,
        'remember_token' => str_random(10),
        ], [
        'first_name' => 'Paolo',
        'last_name' => 'Garcia',
        'username' => 'homeowner4',
        'password' => bcrypt('homeowner4'),
        'email' => 'paolo@gmail.com',
        'pin_code' => null,
        'contact_no' => null,
        'remember_token' => str_random(10),
        ],*/[
            'first_name' => 'Cris',
            'last_name' => 'Toper',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'cris@gmail.com',
            'pin_code' => null,
            'contact_no' => null,
            'remember_token' => str_random(10),
            'main_account_id' => 3,
        ]]);
        //factory(User::class, 10)->create();
    }
}
