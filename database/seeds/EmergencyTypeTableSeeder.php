<?php

use Illuminate\Database\Seeder;

class EmergencyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emergency_type')->insert([
            ['description' => 'Fire'],
            ['description' => 'Intruder'],
            ['description' => 'Medical'],
        ]);
    }
}
