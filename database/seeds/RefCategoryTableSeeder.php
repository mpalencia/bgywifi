<?php

class RefCategoryTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref_category')->insert([
            ['category_name' => 'Social Visit'],
            ['category_name' => 'Construction'],
            ['category_name' => 'Maintenance'],
            ['category_name' => 'Home Service'],
            ['category_name' => 'Delivery'],
            ['category_name' => 'Others'],
        ]);
    }
}
