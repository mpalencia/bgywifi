<?php

use Illuminate\Database\Seeder;

class HomeOwnerAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('homeowner_address')->insert([
            ['home_owner_id' => 1, 'address' => 'South Boulevard, Silang, Calabarzon', 'latitude' => '14.2366558', 'longitude' => '121.0400705', 'primary' => 1],
            ['home_owner_id' => 2, 'address' => 'North 1', 'latitude' => '14.2366558', 'longitude' => '121.0400705', 'primary' => 1],
            ['home_owner_id' => 2, 'address' => 'North 2, Silang, Calabarzon', 'latitude' => '14.2362158', 'longitude' => '121.0370705', 'primary' => 0],
            ['home_owner_id' => 3, 'address' => 'South Boulevard, Silang, Calabarzon', 'latitude' => '14.2366558', 'longitude' => '121.0400705', 'primary' => 1],
        ]);
    }
}
