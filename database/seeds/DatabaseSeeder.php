<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(RefCategoryTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(GuestListTableSeeder::class);
        $this->call(CautionTypeTableSeeder::class);
        $this->call(EmergencyTypeTableSeeder::class);
        $this->call(ActionTakenTypeTableSeeder::class);
        $this->call(HomeOwnerAddressTableSeeder::class);
        Model::reguard();
    }
}
