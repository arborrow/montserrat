<?php

use Illuminate\Database\Seeder;

class TouchcategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('touchcategories')->delete();
        
        \DB::table('touchcategories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Retreat',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Fundraising',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Spirituality',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Vendor',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Captain',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'General',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Volunteer',
                'description' => '',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Prayer',
                'description' => 'Mass intentions and prayer requests',
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}