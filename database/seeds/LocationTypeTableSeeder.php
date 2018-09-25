<?php

use Illuminate\Database\Seeder;

class LocationTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_type')->delete();
        
        \DB::table('location_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Home',
                'display_name' => 'Home',
                'vcard_name' => 'HOME',
                'description' => 'Place of residence',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => 1,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Work',
                'display_name' => 'Work',
                'vcard_name' => 'WORK',
                'description' => 'Work location',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => NULL,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Main',
                'display_name' => 'Main',
                'vcard_name' => NULL,
                'description' => 'Main office location',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => NULL,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Other',
                'display_name' => 'Other',
                'vcard_name' => NULL,
                'description' => 'Other location',
                'is_reserved' => 0,
                'is_active' => 1,
                'is_default' => NULL,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Billing',
                'display_name' => 'Billing',
                'vcard_name' => NULL,
                'description' => 'Billing Address location',
                'is_reserved' => 1,
                'is_active' => 1,
                'is_default' => NULL,
                'deleted_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}