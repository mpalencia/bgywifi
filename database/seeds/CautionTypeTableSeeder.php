<?php

use Illuminate\Database\Seeder;

class CautionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caution_type')->insert([
            ['description' => 'I see smoke'],
            ['description' => 'I heard noise'],
            ['description' => 'I see something suspicious'],
            ['description' => 'Other'],
        ]);
    }
}
