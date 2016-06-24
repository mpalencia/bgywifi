<?php

use Illuminate\Database\Seeder;

class ActionTakenTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('action_taken_type')->insert([
            ['code' => 'Investigating', 'message' => 'Investigating, Guard on the way.'],
            ['code' => 'BFP', 'message' => 'Firetrucks are on the way.'],
            ['code' => 'Police', 'message' => 'Police are on the way.'],
            ['code' => 'Positive', 'message' => 'Positive.'],
            ['code' => 'Resolved', 'message' => 'Alert is now resolved.'],
            ['code' => 'Ambulance', 'message' => 'We need an ambulance'],
            ['code' => 'In Pursuit', 'message' => 'We are in pursuit of the suspect(s).'],
            ['code' => 'Doctor', 'message' => 'We need a doctor here.'],
            ['code' => 'False Positive', 'message' => 'False Alarm.'],
            ['code' => 'Medical', 'message' => 'Medical Issue.'],
        ]);
    }
}
